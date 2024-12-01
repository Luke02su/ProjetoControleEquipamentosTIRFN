<?php
session_start();

if (isset($_POST['usuario']) && isset($_POST['senha'])) {
    $usuario = $_POST['usuario'];
    $senha = $_POST['senha'];

    // Importa o arquivo de conexão e o hash de senha
    include_once('./ConnectionFactory_class.php');
    require_once('./SenhaSha2.php');

    try {
        // Estabelece a conexão com o banco de dados
        $conn = ConnectionFactory::getConnection();
        $sql = "SELECT * FROM usuarios WHERE nome_usuario = ? AND senha = ?";
        $stmt = $conn->prepare($sql);

        // Hashea a senha digitada pelo usuário
        $senhaHash = SenhaSha2::hashSHA256($senha);

        // Vincula os parâmetros com bindValue()
        $stmt->bindValue(1, $usuario, PDO::PARAM_STR);  // Vincula o valor do usuário
        $stmt->bindValue(2, $senhaHash, PDO::PARAM_STR); // Vincula o valor da senha

        // Executa a consulta
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (count($result) > 0) {
            // Usuário autenticado com sucesso, redireciona para 'main.html'
            header("Location: ../visao/main.php");
            exit;
        } else {
            // Autenticação falhou
            $_SESSION['errorMessage'] = "Usuário ou senha incorretos. Tente novamente.";
            header("Location: ../index.php");
            exit;
        }
    } catch (Exception $e) {
        echo "<p style='color:red;'>Erro ao acessar o banco de dados: " . htmlspecialchars($e->getMessage()) . "</p>";
        error_log($e->getMessage());
    } finally {
        // Fecha a conexão
        $stmt = null;  // Libera o recurso de PDOStatement
        if (isset($conn)) $conn = null;  // Fecha a conexão PDO
    }
} else {
    echo "<p style='color:red;'>Por favor, insira o nome de usuário e a senha.</p>";
}
?>
