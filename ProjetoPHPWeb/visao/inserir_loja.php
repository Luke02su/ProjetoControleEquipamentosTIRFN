<?php
        // Inicia a sessão para acessar as variáveis de sessão
        session_start();
        include_once ('./cabecalho_loja.html');
?>
    <h1>Cadastro de Loja</h1>
    <br>
    <form action="../controle/CadastrarLoja_class.php" method="POST">

        <label for="pk_loja">Código da Loja:</label>
        <input type="text" id="pk_loja" name="pk_loja" required  placeholder="Digite o ID da Loja..."><br>
        
        <label for="cnpj">CNPJ:</label>
        <input type="text" id="cnpj" name="cnpj" required  placeholder="Digite o CNPJ c/ m�scara..."><br>

        <label for="gerente">Gerente:</label>
        <input type="text" id="gerente" name="gerente" required placeholder="Digite o primeiro nome do gerente..."><br>

        <label for="cidade">Cidade:</label>
        <input type="text" id="cidade" name="cidade" required  placeholder="Digite a cidade e estado abreviado..."><br>

        <label for="telefone">Telefone:</label>
        <input type="text" id="telefone" name="telefone" required placeholder="Digite o telefone c/ DDD..."><br>

        <button type="submit" name="enviar">Cadastrar</button>
        <button type="reset" name="limpar">Limpar</button>

        <?php
        // Verifica se a mensagem de sucesso foi definida
        if (isset($_SESSION['mensagemSucesso'])) {
            if ($_SESSION['mensagemSucesso'] == 1) {
                echo "<p>Cadastro realizado com sucesso!</p>";  // Mensagem de sucesso
            }

            // Limpa a variável de sessão para não exibir a mensagem novamente
            unset($_SESSION['mensagemSucesso']);
        }
        ?>
    </form>
<?php
    include_once ('./rodape.html');
?>