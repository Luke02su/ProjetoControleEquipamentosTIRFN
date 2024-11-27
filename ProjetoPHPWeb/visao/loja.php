<?php
        include_once ('./cabecalho_loja.html');
?>  
        <div id="texto-loja">
            <h2>Instruções do CRUD Loja:</h2>
            <p><b>Inserir loja:</b> Insira os dados da nova loja da Farmácia Nacional, ou alguma que esteja faltando. 
            Os dados são: ID da loja, CNPJ, gerente, cidade e telefone. O acesso a esses dados facilitarão em alguma 
            tomada de decisão, como no envio de equipamento.
            <br>
            <br>
            <b>Listar lojas:</b> Lista os dados de todas as lojas cadastradas em formato de tabela.<br>
            Ideal para saber a quantidade total de lojas cadastradas, bem como em casos em que se sabe o nome do gerente, e não o número da loja.
            <br>
            <br>
            <b>Exibir loja:</b> Exibe todos os dados de uma loja específica.
            Ideal para saber os dados específicos de uma loja que já se sabe qual é.
            <br>
            <br>
            <b>Atualizar loja:</b> Atualiza o dado que desejar de uma loja específica.
            Ideal para para quando se insere algum dado errado e deseja alterá-lo de forma rápida, sem ter que excluir e inserir tudo novamente.
            <br>
            <br>
            <b>Excluir loja:</b> Exclui todos os dados de uma loja específica.
            Ideal para quando se insere dados completamente errados e deseja excluí-los. E quase nunca será usado, pois se tem o atualizar.
            <p>
        </div>
<?php
    include_once ('./rodape.html');
?>