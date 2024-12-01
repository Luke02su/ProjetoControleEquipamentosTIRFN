<?php
session_start();
include_once('./cabecalho_computador.html');
?>
<h1>Exibir Loja</h1>
<br>
<form action="../modelo/comparar_cpu.php" method="POST">
    <label for="cpu1">CPU 1:</label>
    <input type="text" id="cpu1" name="cpu1" required placeholder="Digite a primeira CPU..."><br><br>

    <label for="cpu2">CPU 2:</label>
    <input type="text" id="cpu2" name="cpu2" required placeholder="Digite a segunda CPU..."><br><br>
    <button type="submit" name="pesquisar">Comparar</button>
</form>

<?php
if (isset($_GET['cpu1'], $_GET['ratings_cpu1'], $_GET['cpu2'], $_GET['ratings_cpu2'])) {
    $cpu1 = $_GET['cpu1'];
    $ratings_cpu1 = $_GET['ratings_cpu1']; // Já é uma string JSON
    $cpu2 = $_GET['cpu2'];
    $ratings_cpu2 = $_GET['ratings_cpu2']; // Já é uma string JSON

    // Exibir as informações
    echo "<h1>Resultados Comparativos</h1>";

    echo "<h2>CPU 1: $cpu1</h2>";
    echo "<pre>" . print_r(json_decode($ratings_cpu1, true), true) . "</pre>"; // Decodificar JSON aqui

    echo "<h2>CPU 2: $cpu2</h2>";
    echo "<pre>" . print_r(json_decode($ratings_cpu2, true), true) . "</pre>"; // Decodificar JSON aqui
}
include_once('./rodape.html');
?>


