<?php

class Persons_Model_SocialProject extends Agana_Data_Bean {

    /**
     * @var int id
     */
    private $id;

    /**
     * @var string nome do programa
     */
    private $nome;

    /**
     * @return string sigla
     */
    private $sigla;
    
    public function getSigla() {
        return $this->sigla;
    }

    public function setSigla($sigla) {
        $this->sigla = $sigla;
        return $this;
    }

    public function getId() {
        return $this->id;
    }

    public function getNome() {
        return $this->nome;
    }

    public function setId($id) {
        $this->id = $id;
        return $this;
    }

    public function setNome($nome) {
        $this->nome = $nome;
        return $this;
    }
}

