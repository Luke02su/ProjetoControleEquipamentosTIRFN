<?php
class Connectionfactory {
    // Propriedades estáticas
    public static $con = null; // Variável estática para conexão
    public static $dbType = "mysql";
    public static $host = "127.0.0.1";
    public static $user = "root";
    public static $senha = "admin";
    public static $db = "controle_equipamentos_ti";
    public static $persistente = false; // Conexão não persistente

    // Método estático para obter a conexão
    public static function getConnection() { 
        try { 
            // Conectando ao banco usando PDO
            self::$con = new PDO(
                self::$dbType.":host=".self::$host.";port=3306;dbname=".self::$db, 
                self::$user,
                self::$senha,
                array(PDO::ATTR_PERSISTENT => self::$persistente, 
                      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION)
            );
            return self::$con; // Retorna a conexão
        } catch (PDOException $ex) { 
            echo "Erro: " . $ex->getMessage(); // Caso ocorra um erro, exibe a mensagem
        }
    }

    // Método estático para fechar a conexão
    public static function close() { 
        if (self::$con != null) { 
            self::$con = null; // Fecha a conexão
        }
    }
}
?>
