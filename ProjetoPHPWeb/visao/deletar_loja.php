<?php
        // Inicia a sessão para acessar as variáveis de sessão
        session_start();
        include_once ('./cabecalho_loja.html');
?>
    <h1>Apagar Loja</h1>
    <br>
    <form action="../controle/ExcluirLoja_class.php" method="POST">
        <label for="pk_loja">Código da Loja:</label>
        <input type="text" id="pk_loja" name="pk_loja" required  placeholder="Digite o ID da Loja..."><br><br>

        <button type="submit" name="deletar">Apagar</button>

        <!-- Exibe a mensagem de sucesso ou erro -->
    <?php
    if (isset($_SESSION['mensagemExclusao'])) {
        if ($_SESSION['mensagemExclusao'] == 1) {
            echo "<p style='color: green; font-weight: bold;'>Loja excluída com sucesso!</p>"; // Mensagem de sucesso
        } else {
            echo "<p style='color: red; font-weight: bold;'>Erro ao excluir a loja. Verifique se o ID existe.</p>"; // Mensagem de erro
        }

        // Limpa a variável de sessão para não exibir a mensagem novamente
        unset($_SESSION['mensagemExclusao']);
    }
?>

    </form>
<?php
    include_once ('./rodape.html');
?>