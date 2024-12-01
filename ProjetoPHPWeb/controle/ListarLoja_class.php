<?php
include_once("../modelo/LojaDAO_class.php");

class ListarLoja {
    private $lista;

    public function __construct() {
        $dao = new LojaDAO();
        $this->lista = $dao->listar(); // Armazena a lista de lojas internamente
    }

    // Método público para obter a lista
    public function getLista() {
        return $this->lista;
    }
}
?>
