<?php
// Inicia a sessão para acessar as variáveis de sessão
session_start();
include_once('./cabecalho_loja.html');

require_once('../modelo/LojaDAO_class.php'); // Arquivo contendo a classe LojaDAO
require_once('../modelo/Loja_class.php');    // Arquivo contendo a classe Loja

// Verifica se o parâmetro pk_loja foi enviado e é válido
if (isset($_POST['pk_loja']) && is_numeric($_POST['pk_loja'])) {
    $pk_loja = intval($_POST['pk_loja']); // Converte para inteiro
} else {
    die("ID da loja inválido."); // Mensagem de erro se o ID não for válido
}

// Instancia o DAO e busca os dados da loja
$dao = new LojaDAO();
$loja = $dao->exibir($pk_loja); // Chama o método para buscar os dados

// Verifica se a loja foi encontrada
if (!$loja) {
    die("Loja não encontrada."); // Exibe mensagem se o ID for inexistente
}
?>

<h1>Atualizar Loja</h1>
<br>
<form action="../controle/AlterarLoja_class.php" method="POST">

    <label for="pk_loja">Código da Loja:</label>
    <input type="text" id="pk_loja" name="pk_loja" value="<?php echo htmlspecialchars($loja->getPk_loja()); ?>" readonly ><br>

    <label for="cnpj">CNPJ:</label>
    <input type="text" id="cnpj" name="cnpj" value="<?php echo htmlspecialchars($loja->getCnpj()); ?>" required placeholder="Digite o CNPJ com máscara..."><br>

    <label for="gerente">Gerente:</label>
    <input type="text" id="gerente" name="gerente" value="<?php echo htmlspecialchars($loja->getGerente()); ?>" required placeholder="Digite o nome do gerente..."><br>

    <label for="cidade">Cidade:</label>
    <input type="text" id="cidade" name="cidade" value="<?php echo htmlspecialchars($loja->getCidade()); ?>" required placeholder="Digite a cidade e estado abreviado..."><br>

    <label for="telefone">Telefone:</label>
    <input type="text" id="telefone" name="telefone" value="<?php echo htmlspecialchars($loja->getTelefone()); ?>" required placeholder="Digite o telefone com DDD..."><br>

    <button type="submit" name="enviar">Atualizar</button>
    <button type="reset" name="limpar">Limpar</button>

    <?php
    // Verifica se a mensagem de sucesso foi definida
    if (isset($_SESSION['mensagemSucesso'])) {
        if ($_SESSION['mensagemSucesso'] == 1) {
            echo "<p style='color: green;'>Cadastro atualizado com sucesso!</p>"; // Mensagem de sucesso
        }

        // Limpa a variável de sessão para não exibir a mensagem novamente
        unset($_SESSION['mensagemSucesso']);
    }
    ?>
</form>

<?php include_once('./rodape.html'); ?>
