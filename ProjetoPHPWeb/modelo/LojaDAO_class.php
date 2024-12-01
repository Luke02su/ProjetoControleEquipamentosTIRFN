<?php
// LojaDAO_class.php
include_once("../modelo/ConnectionFactory_class.php");
include_once("../modelo/Loja_class.php");

class LojaDAO {
    public $con = null;

    public function __construct() {
        $conF = new ConnectionFactory();
        $this->con = $conF->getConnection();
    }

    public function cadastrar($loja) {
        try {
            $stmt = $this->con->prepare(
                "INSERT INTO loja (pk_loja, cnpj, gerente, cidade, telefone) 
                VALUES (:pk_loja, :cnpj, :gerente, :cidade, :telefone)"
            );
            $stmt->bindValue(":pk_loja", $loja->getPk_loja());
            $stmt->bindValue(":cnpj", $loja->getCnpj());
            $stmt->bindValue(":gerente", $loja->getGerente());
            $stmt->bindValue(":cidade", $loja->getCidade());
            $stmt->bindValue(":telefone", $loja->getTelefone());

            $stmt->execute();
            
            echo "Cadastro realizado com sucesso!";
        } catch (PDOException $ex) {
            echo "Erro ao cadastrar: " . $ex->getMessage();
        }
    }

    public function listar($query = null) {  
        try {
            // Verifica se uma query personalizada foi passada
            if ($query == null) {
                $dados = $this->con->query("SELECT * FROM loja");
            } else {
                $dados = $this->con->query($query);
            }
    
            // Garante que a consulta retornou resultados
            if (!$dados) {
                throw new PDOException("Nenhum dado retornado pela consulta.");
            }
    
            $lista = []; // Cria o array para armazenar as lojas
    
            // Itera sobre os resultados retornados pela consulta
            foreach ($dados as $linha) {
                $l = new Loja();
                $l->setPk_loja($linha["pk_loja"]);
                $l->setCnpj($linha["cnpj"]);
                $l->setGerente($linha["gerente"]);
                $l->setCidade($linha["cidade"]);
                $l->setTelefone($linha["telefone"]);
                $lista[] = $l; // Adiciona o objeto Loja à lista
            }
    
            return $lista; // Retorna a lista de lojas
        } catch (PDOException $ex) {
            // Exibe uma mensagem de erro detalhada e retorna um array vazio
            echo "Erro ao listar lojas: " . $ex->getMessage();
            return [];
        }
    }

    //exibir 
	public function exibir($pk_loja){			
		try{				
			$lista = $this->con->query("SELECT * FROM loja WHERE pk_loja = " . $pk_loja);
				
            $dado = $lista->fetchAll(PDO::FETCH_ASSOC);
            
            $l = new Loja();
            $l->setPk_loja($dado[0]["pk_loja"]);
            $l->setCnpj($dado[0]["cnpj"]);
            $l->setGerente($dado[0]["gerente"]);
            $l->setCidade($dado[0]["cidade"]);
            $l->setTelefone($dado[0]["telefone"]);
            
            return $l;	
        }
        catch(PDOException $ex){
            echo "Erro: " . $ex->getMessage();
        }
    }

    //alterar
    public function alterar($cont){
        try{
            $stmt = $this->con->prepare(
            "UPDATE loja SET pk_loja=:pk_loja, 
            cnpj = :cnpj, gerente=:gerente, cidade=:cidade, telefone=:telefone WHERE
            pk_loja=:pk_loja");
            
            //ligamos as âncoras aos valores de Contato
            $stmt->bindValue(":pk_loja", $cont->getPk_loja());
            $stmt->bindValue(":cnpj", $cont->getCnpj());
            $stmt->bindValue(":gerente", $cont->getGerente());
            $stmt->bindValue(":cidade", $cont->getCidade());
            $stmt->bindValue(":telefone", $cont->getTelefone());
            
            $this->con->beginTransaction();
            $stmt->execute(); //execução do SQL	
            $this->con->commit(); 

        }
        catch(PDOException $ex){
            echo "Erro: " . $ex->getMessage();
        }
    }

    //excluir
    public function excluir($pk_loja) {
        try {
            // Prepara a consulta para exclusão
            $stmt = $this->con->prepare("DELETE FROM loja WHERE pk_loja = :pk_loja");
    
            // Associa o ID ao parâmetro
            $stmt->bindValue(":pk_loja", $pk_loja, PDO::PARAM_INT);
    
            // Executa o comando
            $stmt->execute();
    
            // Retorna 1 se pelo menos uma linha foi afetada
            return $stmt->rowCount() >= 1 ? 1 : 0;
        } catch (PDOException $ex) {
            echo "Erro: " . $ex->getMessage();
            return 0;
        }
    }    
}
?>
