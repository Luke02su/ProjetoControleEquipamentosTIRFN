<!DOCTYPE html>
    <html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="author" content="Lucas Samuel Dias"> <!--Autor do site.-->
        <link rel="stylesheet" href="./estilos/estilo_main.css">
        <title>Página Inicial</title>
    </head>
    <body>
        <div class="header-nav">
            <header>
                <h1>Controle de Equipamentos de TI da RFN</h1>
            </header>
            <hr>
            <nav>
                <a href="./computador.php">Computadores</a><p>|</p>
                <a href="#">Impressoras não fiscais</a><p>|</p>
                <a href="#">Equipamentos genérico</a><p>|</p>
                <a href="./loja.php">Lojas</a><p>|</p>
                <a href="#">Envios atuais</a><p>|</p>
                <a href="#">Envios antigos</a><p>|</p>
                <a href="#">Equipamentos descartados</a>
            </nav>
        </div>
        <hr>
        <main>
            <article>
                <h2>Bem-vindo ao sistema Controle de Equipamentos de TI da RFN!</h2>
                <p>
                    Esse ambiente foi criado para sanar a não autonomia de planilhas eletrônicas, experimentado por mim durante o controle diário dos equipamentos de TI.<br>
                    O principal objetivo de se utilizar esse sistema ao invés de uma planilha para o controle de equipamentos, refere-se 
                    à maior proteção de integridade, maior escalabilidade e eficiência.   
                </p>
    <?php
        include_once ('./rodape.html');
    ?>