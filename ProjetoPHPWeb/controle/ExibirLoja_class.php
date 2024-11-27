<?php
session_start();  // Inicia a sessão no início do arquivo

include_once("../modelo/LojaDAO_class.php");

class ExibirLoja {
    public function __construct() {
        // Verifica se o parâmetro pk_loja foi enviado via POST
        if (isset($_POST["pk_loja"])) {
            $dao = new LojaDAO();
            $cont = $dao->exibir($_POST["pk_loja"]);  // Usando POST aqui em vez de GET

            if ($cont) {
                $_SESSION['loja'] = $cont;  // Armazenando os dados da loja na sessão
                header("Location: ../visao/exibir_loja.php");  // Redireciona para a página de exibição
                exit(); // Interrompe a execução após o redirecionamento
            } else {
                echo "Loja não encontrada.";
            }
        } else {
            echo "ID da loja não informado.";
        }
    }
}

new ExibirLoja();

?>