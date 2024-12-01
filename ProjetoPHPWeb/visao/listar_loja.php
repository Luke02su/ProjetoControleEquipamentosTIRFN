<?php
session_start();
include_once('./cabecalho_loja.html');
include_once("../modelo/LojaDAO_class.php");
include_once("../controle/ListarLoja_class.php");

$listar = new ListarLoja();
$lista = $listar->getLista();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Lojas</title>
    <style>
        table {
            height: 100px;
            width: 900px;
            border: 1px solid green;
        }

        th, td {
            border-top: 1px solid green;
            border-right: 1px solid green;
            font-size: 10px;
        } 
    </style>
</head>
<body>
    <?php if (empty($lista)): ?>
        <p>Nenhuma loja cadastrada.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>ID</th>
                <th>CNPJ</th>
                <th>Gerente</th>
                <th>Cidade</th>
                <th>Telefone</th>
            </tr>
            <?php foreach ($lista as $loja): ?>
                <tr>
                    <td><?php echo htmlspecialchars($loja->getPk_loja()); ?></td>
                    <td><?php echo htmlspecialchars($loja->getCnpj()); ?></td>
                    <td><?php echo htmlspecialchars($loja->getGerente()); ?></td>
                    <td><?php echo htmlspecialchars($loja->getCidade()); ?></td>
                    <td><?php echo htmlspecialchars($loja->getTelefone()); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</body>
</html>
<?php include_once('./rodape.html'); ?>
