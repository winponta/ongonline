<?php

/**
 * Validação de OR Lógica
 *
 * @author   Wanderson Henrique Camargo Rosa
 * @package  Agana
 * @category Agana_Validate
 */
class Agana_Validate_Or extends Zend_Validate {

    // Validação Sobrescrita
    public function isValid($value) {
        // Mensagens de Erro
        $this->_messages = array();
        // Constantes de Erro
        $this->_errors = array();
        // Resultado Inicial
        $result = false;
        // Todos os Validadores
        foreach ($this->_validators as $element) {
            $validator = $element['instance'];
            // Verificação
            $valid = $validator->isValid($value);
            $result = $result || $valid;
            // Mensagens Informadas pelo Validador
            $messages = $validator->getMessages();
            // Mesclagem de Erros
            $this->_messages = array_merge($this->_messages, $messages);
            $this->_errors = array_merge($this->_errors, array_keys($messages));
            // Parar quando Validação Inválida
            if (!$result && $element['breakChainOnFailure']) {
                break;
            }
        }
        return $result;
    }

}

?>
