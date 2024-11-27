<?php
include_once('../visao/cabecalho_loja.html');
include_once("../modelo/Loja_class.php");

session_start();

// Verifica se os dados da loja estão na sessão
if (isset($_SESSION['loja'])) {
    $cont = $_SESSION['loja'];

    // Exibir os dados da loja
    echo "<h1>Loja " . $cont->getPk_loja() . "</h1>";
    echo "<ul>";
    echo "<li>ID: " . $cont->getPk_loja() . "</li>";
    echo "<li>CNPJ: " . $cont->getCnpj() . "</li>";
    echo "<li>Gerente: " . $cont->getGerente() . "</li>";
    echo "<li>Cidade: " . $cont->getCidade() . "</li>";
    echo "<li>Telefone: " . $cont->getTelefone() . "</li>";
    echo "</ul>";

    // Opcionalmente, limpa a variável de sessão após exibição
    unset($_SESSION['loja']);
} else {
    echo "ID da loja não encontrado na sessão.";
}

include_once('../visao/rodape.html');
?>
