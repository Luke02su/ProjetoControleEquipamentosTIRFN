<?php

// Base URL para buscar detalhes da CPU
$baseURL = "https://www.cpubenchmark.net/cpu.php?cpu=";

// Função para buscar Multithread Rating e Single Thread Rating
function fetch_cpu_ratings($cpu_name) {
    global $baseURL;

    // Construir a URL com o nome da CPU
    $url = $baseURL . urlencode($cpu_name);

    // Inicializar cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Simula um navegador
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    // Desabilita a verificação SSL
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    // Desabilita a verificação do host SSL
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if (!$result) {
        throw new Exception("Erro ao buscar dados do site: $error");
    }

    // Carregar o HTML no DOMDocument
    $dom = new DOMDocument();
    @$dom->loadHTML($result);
    $xpath = new DOMXPath($dom);

    // Inicializar as variáveis para armazenar os resultados
    $ratings = [
        "Multithread Rating" => null,
        "Single Thread Rating" => null
    ];

    // XPath para localizar Multithread Rating
    $multithreadNode = $xpath->query("//div[contains(text(),'Multithread Rating')]/following-sibling::div");
    if ($multithreadNode->length > 0) {
        $ratings["Multithread Rating"] = trim($multithreadNode->item(0)->nodeValue);
    }

    // XPath para localizar Single Thread Rating
    $singleThreadNode = $xpath->query("//div[contains(text(),'Single Thread Rating')]/following-sibling::div");
    if ($singleThreadNode->length > 0) {
        $ratings["Single Thread Rating"] = trim($singleThreadNode->item(0)->nodeValue);
    }

    return $ratings;
}

// Rota para lidar com a requisição
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['cpu_name'])) {
        $cpu_name = $_GET['cpu_name'];

        try {
            $cpu_ratings = fetch_cpu_ratings($cpu_name);
            header('Content-Type: application/json');
            echo json_encode($cpu_ratings, JSON_PRETTY_PRINT);
        } catch (Exception $e) {
            header("HTTP/1.1 500 Internal Server Error");
            echo json_encode(["error" => $e->getMessage()]);
        }
    } else {
        header("HTTP/1.1 400 Bad Request");
        echo json_encode(["error" => "Por favor, informe o parâmetro 'cpu_name'."]);
    }
}
?>
