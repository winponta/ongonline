<?php
/**
 * Validador para Cadastro de Pessoas
 *
 * Implementação de algoritmos para cadastro de pessoas físicas e jurídicas
 * conforme Ministério da Fazenda do Governo Federal.
 *
 * @category Agana
 * @package  Agana_Validate
 * @author   Ademir Mazer Junior
 * @link http://www.wanderson.camargo.nom.br/2011/07/validador-de-cpf-e-cnpj-para-zend-framework/ based on Wanderson Henrique Camargo Rosa original blog post
 */
abstract class Agana_Validate_Doc_Abstract extends Zend_Validate_Abstract
{
    /**
     * Tamanho Inválido
     * @var string
     */
    const SIZE = 'size';
 
    /**
     * Números Expandidos
     * @var string
     */
    const EXPANDED = 'expanded';
 
    /**
     * Dígito Verificador
     * @var string
     */
    const DIGIT = 'digit';
 
    /**
     * Tamanho do Campo
     * @var int
     */
    protected $_size = 0;
 
    /**
     * Modelos de Mensagens
     * @var string
     */
    protected $_messageTemplates = array(
        self::SIZE      => "'%value%' não possui o tamanho esperado",
        self::EXPANDED  => "'%value%' não possui um formato aceitável",
        self::DIGIT     => "'%value%' não é um documento válido"
    );
 
    /**
     * Modificadores de Dígitos
     * @var array
     */
    protected $_modifiers = array();
 
    /**
    * Validação Interna do Documento
    * @param string $value Dados para Validação
    * @return boolean Confirmação de Documento Válido
    */
    protected function _check($value)
    {
        // Captura dos Modificadores
        foreach ($this->_modifiers as $modifier) {
            $result = 0; // Resultado Inicial
            $size = count($modifier); // Tamanho dos Modificadores
            for ($i = 0; $i < $size; $i++) {
                $result += $value[$i] * $modifier[$i]; // Somatório
            }
            $result = $result % 11;
            $digit  = ($result < 2 ? 0 : 11 - $result); // Dígito
            // Verificação
            if ($value[$size] != $digit) {
                return false;
            }
        }
        return true;
    }
 
    public function isValid($value)
    {
        // Filtro de Dados
        $data = preg_replace('/[^0-9]/', '', $value);
        // Verificação de Tamanho
        if (strlen($data) != $this->_size) {
            $this->_error(self::SIZE, $value);
            return false;
        }
        // Verificação de Dígitos Expandidos
        if (str_repeat($data[0], $this->_size) == $data) {
            $this->_error(self::EXPANDED, $value);
            return false;
        }
        // Verificação de Dígitos
        if (!$this->_check($data)) {
            $this->_error(self::DIGIT, $value);
            return false;
        }
        // Comparações Concluídas
        return true; // Todas Verificações Executadas
    }
 
}
?>