<?php
    include_once("../modelo/LojaDAO_class.php");

    class ListarLoja {

        public function __construct() {
            echo "Iniciando ListarLoja...<br>";
    
            $dao = new LojaDAO();
            echo "Criando instância de LojaDAO...<br>";
    
            $lista = $dao->listar();  // Obtém a lista de lojas
            echo "Consulta executada, verificando resultados...<br>";
    
            // Verifica se a lista não está vazia
            if (empty($lista)) {
                echo "Nenhuma loja cadastrada.";  // Exibe mensagem caso não haja lojas
            } else {
                echo "Lojas encontradas, carregando visão...<br>";
                include_once("../visao/lista_loja.php");
            }
        }
    }
?>