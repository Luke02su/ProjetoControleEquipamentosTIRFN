<?php
session_start();  // Inicia a sessão no início do arquivo

include_once("../modelo/LojaDAO_class.php");

class ExcluirLoja {
    public function __construct() {
        // Verifica se o parâmetro pk_loja foi enviado via POST
        if (isset($_POST["pk_loja"])) {
            $dao = new LojaDAO();

            // Chama o método de exclusão diretamente com o ID
            $resultado = $dao->excluir($_POST["pk_loja"]);

            if ($resultado) {
                // Armazena mensagem de sucesso na sessão
                $_SESSION['mensagemExclusao'] = 1;
                header("Location: ../visao/deletar_loja.php");
                exit(); // Interrompe a execução após o redirecionamento
            } else {
                echo "Erro ao excluir a loja. Verifique se o ID existe.";
            }
        } else {
            echo "ID da loja não informado.";
        }
    }
}

// Instancia a classe para executar a operação
new ExcluirLoja();
?>
