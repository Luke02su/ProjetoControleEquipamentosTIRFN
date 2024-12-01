<?php
session_start(); // Iniciar sessão para passar dados se necessário

// Base URL para buscar detalhes da CPU
$baseURL = "https://www.cpubenchmark.net/cpu.php?cpu=";

// Função para buscar Multithread Rating e Single Thread Rating
function fetch_cpu_ratings($cpu_name) {
    global $baseURL;

    $url = $baseURL . urlencode($cpu_name);

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0'); // Simula um navegador
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);    
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);    
    $result = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);

    if (!$result) {
        throw new Exception("Erro ao buscar dados do site: $error");
    }

    $dom = new DOMDocument();
    @$dom->loadHTML($result);
    $xpath = new DOMXPath($dom);

    $ratings = [
        "Multithread Rating" => null,
        "Single Thread Rating" => null
    ];

    $multithreadNode = $xpath->query("//div[contains(text(),'Multithread Rating')]/following-sibling::div");
    if ($multithreadNode->length > 0) {
        $ratings["Multithread Rating"] = trim($multithreadNode->item(0)->nodeValue);
    }

    $singleThreadNode = $xpath->query("//div[contains(text(),'Single Thread Rating')]/following-sibling::div");
    if ($singleThreadNode->length > 0) {
        $ratings["Single Thread Rating"] = trim($singleThreadNode->item(0)->nodeValue);
    }

    return $ratings;
}

// Processar o formulário
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cpu1 = $_POST['cpu1'] ?? null;
    $cpu2 = $_POST['cpu2'] ?? null;

    if (!$cpu1 || !$cpu2) {
        echo "Por favor, insira o nome de ambas as CPUs.";
        exit;
    }

    try {
        $ratings_cpu1 = fetch_cpu_ratings($cpu1);
        $ratings_cpu2 = fetch_cpu_ratings($cpu2);

// Montar query string para redirecionar com os dados
$queryString = http_build_query([
    'cpu1' => $cpu1,
    'ratings_cpu1' => json_encode($ratings_cpu1), // Convertendo para JSON
    'cpu2' => $cpu2,
    'ratings_cpu2' => json_encode($ratings_cpu2)  // Convertendo para JSON
]);

// Redirecionar para a página inserir_comparar_cpu.php com os dados
header("Location: ../visao/inserir_comparar_cpu.php?$queryString");
exit;


    } catch (Exception $e) {
        echo "Erro ao buscar dados: " . $e->getMessage();
    }
} else {
    echo "Por favor, envie o formulário.";
}
?>
