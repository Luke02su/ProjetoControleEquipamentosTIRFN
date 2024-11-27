<?php
    class Loja {
    //classe entidade
        private $pk_loja;
        private $cnpj;
        private $gerente;
        private $cidade;
        private $telefone;

        public function __construct() {

        }

        public function setPk_loja($pk_loja) {
            $this->pk_loja = $pk_loja;
        }

        public function getPk_loja() {
            return $this->pk_loja;
        }

        public function setCnpj($cnpj) {
            $this->cnpj = $cnpj;
        }

        public function getCnpj() {
            return $this->cnpj;
        }

        public function setGerente($gerente) {
            $this->gerente = $gerente;
        }

        public function getGerente() {
            return $this->gerente;
        }

        public function setCidade($cidade) {
            $this->cidade = $cidade;
        }

        public function getCidade() {
            return $this->cidade;
        }

        public function setTelefone($telefone) {
            $this->telefone = $telefone;
        }

        public function getTelefone() {
            return $this->telefone;
        }

    }

?>