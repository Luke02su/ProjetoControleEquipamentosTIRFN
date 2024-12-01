<?php
        // Inicia a sessão para acessar as variáveis de sessão
        session_start();
        include_once ('./cabecalho_loja.html');
?>
    <h1>Exibir Loja</h1>
    <br>
    <form action="../controle/ExibirLoja_class.php" method="POST">
        <label for="pk_loja">Código da Loja:</label>
        <input type="text" id="pk_loja" name="pk_loja" required  placeholder="Digite o ID da Loja..."><br><br>

        <button type="submit" name="exibir">Exibir</button>

    </form>
<?php
    include_once ('./rodape.html');
?>