<?php

/**
 * Validador para Cadastro de Pessoa Física
 *
 * @author   Ademir Mazer Junior
 * @category Agana
 * @package  Agana_Validate
 * @link http://www.wanderson.camargo.nom.br/2011/07/validador-de-cpf-e-cnpj-para-zend-framework/ based on Wanderson Henrique Camargo Rosa original blog post
 */
class Agana_Validate_Cpf extends Agana_Validate_Doc_Abstract {

    /**
     * Tamanho do Campo
     * @var int
     */
    protected $_size = 11;

    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $_modifiers = array(
        array(10, 9, 8, 7, 6, 5, 4, 3, 2),
        array(11, 10, 9, 8, 7, 6, 5, 4, 3, 2)
    );

}

?>
