<?php
// CadastrarLoja.php
include_once("../modelo/LojaDAO_class.php");

class CadastrarLoja {
    public function __construct() {
        // Iniciar a sessão para usar variáveis de sessão
        session_start();

        if (isset($_POST["enviar"])) { // está setado para enviar?
            echo "Formulário enviado<br>"; // Verifique se a condição foi atendida

            // Criando objeto Loja
            $l = new Loja();
            $l->setPk_loja($_POST["pk_loja"]);
            $l->setCnpj($_POST["cnpj"]);
            $l->setGerente($_POST["gerente"]);
            $l->setCidade($_POST["cidade"]);
            $l->setTelefone($_POST["telefone"]);
            
            // Criando objeto LojaDAO e chamando o método cadastrar
            $dao = new LojaDAO();
            $dao->cadastrar($l);

            // Status de sucesso
            $status = "Cadastro de Loja " . $l->getPk_loja() . " efetuado com sucesso";
            echo $status;

            // Definindo a variável de sessão para a mensagem de sucesso
            $_SESSION['mensagemSucesso'] = 1;  // 1 indicando sucesso

            // Redireciona para a página de cadastro
            header("Location: ../visao/inserir_loja.php");  // Redireciona
            exit;  // Impede que o código continue executando após o redirecionamento
        } else {
            echo "Formulário não enviado<br>";
            include_once("visao/formCadastroContato.php");
        }
    }
}

// Chama a classe ao acessar o arquivo
new CadastrarLoja();
?>
