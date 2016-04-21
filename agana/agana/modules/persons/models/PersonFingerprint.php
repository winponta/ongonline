<?php

class Persons_Model_PersonFingerprint extends Agana_Data_Bean {
    private $fingerNumbers = array(
        'direita' => array(
            'polegar' => 1,
            'indicador' => 2,
            'medio' => 3,
            'anelar' => 4,
            'minimo' => 5,
        ),
        'esquerda' => array(
            'polegar' => 6,
            'indicador' => 7,
            'medio' => 8,
            'anelar' => 9,
            'minimo' => 10,
        )
    );
    
    /**
     *
     * @var Integer Person id
     */
    private $person_id;

    /**
     * @var integer
     */
    private $finger_number;
    
    /**
     * @var String
     */
    private $text_hash;

    public function getPerson_id() {
        return $this->person_id;
    }

    public function getFinger_number() {
        return $this->finger_number;
    }

    public function getText_hash() {
        return $this->text_hash;
    }

    public function setPerson_id($person_id) {
        $this->person_id = $person_id;
        return $this;
    }

    public function setFinger_number($finger_number) {
        $this->finger_number = $finger_number;
        return $this;
    }

    public function setText_hash($text_hash) {
        $this->text_hash = $text_hash;
        return $this;
    }

//    public function getFingerName() {
//        $name = array_search($this->finger_number, $this->fingerNumbers);
//
//        $name = $name === FALSE ? '' : $name;
//        
//        return $name;
//    }
    
    public function getFingerHand() {
        if ($this->finger_number > 0 && $this->finger_number < 6) {
            return 'direita';
        } else if ($this->finger_number > 0 && $this->finger_number < 6) {
            return 'esquerda';
        } else {
            return 'dedo não definido';
        }
    }
    
    public function getFingerName() {
        switch ($this->finger_number) {
            case 1: case 6:
                return 'polegar';break;
            case 2: case 7:
                return 'indicador';break;
            case 3: case 8:
                return 'médio';break;
            case 4: case 9:
                return 'anelar';break;
            case 5: case 10:
                return 'mínimo';break;
        }
    }

    public function toArray() {
        $result = get_object_vars($this);
        unset($result['fingerNumbers']);
        return $result;
    }}

