<?php
    session_start(); //Inicia a sessão
    //área de memória dentro do servidor
    //carrinho de compras, seus dados de conexão
    //qualquer variável que vc queira criar
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
        <link rel="stylesheet" href="./visao/estilos/estilo_login.css">
    </head>
    <body>
        <article>
            <div class="titulo">
                <h1>Controle de Equipamentos de TI da RFN</h1>
            </div>

            <?php
            // Recupera a mensagem de erro armazenada na variável de sessão ou outra fonte
            $errorMessage = isset($_SESSION['errorMessage']) ? $_SESSION['errorMessage'] : '';
            
            if (!empty($errorMessage)) {
                echo '<p id="mensagemErro">' . htmlspecialchars($errorMessage, ENT_QUOTES, 'UTF-8') . '</p>';
                // Opcional: remover a mensagem da sessão após exibi-la
                unset($_SESSION['errorMessage']);
            }
            ?>
            
            <aside>
                <div id="logo">
                    <a id="logo" href="./index.php">
                        <img src="./visao/Imagens/rfn.png">
                    </a>
                </div>
                <form action="./modelo/login.php" method="post">
                    <div class="label-input">
                        <label for="usuario">Usuário:</label>
                        <input type="text" id="usuario" name="usuario" placeholder="Digite seu usuário..." size="15" maxlength="15" required>
                    </div>
                    <div class="label-input">
                        <label for="senha">Senha:</label>
                        <input type="password" id="senha" name="senha" placeholder="Digite sua senha..." size="15" maxlength="15" required>
                    </div>
                    <div class="botao-envio">
                        <input type="submit" value="Entrar">
                    </div>
                </form>
            </aside>
        </article>
    </body>
</html>