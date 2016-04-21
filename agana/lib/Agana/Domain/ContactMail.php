<?php

/**
 * Agana_Domain_Contact
 *
 * controls the sending of a contact from web sites through email
 * 
 * @category   Agana
 * @package    Agana_Contact
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Domain_ContactMail {

    protected $_contactMail = null;

    public function __construct($contactMail = null) {
        $this->_contactMail = $contactMail;
    }

    public function send() {
        $bodyMessage =
                "MENSAGEM:
        
		" .
                $this->_contactMail->getMessage() . "

		NOME DO CONTATO: " . $this->_contactMail->getName() . "
		E-MAIL PARA RESPOSTA: " . $this->_contactMail->getFrom() . "

		IP:$_SERVER[REMOTE_ADDR]";

        /*
         * send the email 
         */
        try {
            $mail = new Zend_Mail();
            $mail->setBodyText($bodyMessage);
            $mail->setFrom($this->_contactMail->getFrom(), $this->_contactMail->getName());
            $mail->addTo($this->_contactMail->getTo());
            $mail->setSubject($this->_contactMail->getSubject());
            
            $mail->send();

            // To sender
            // TODO internacionalization
            $bodyMessage = "Sua mensagem enviada como contato para " . $this->_contactMail->getTo() . ":
                                " . $bodyMessage;

            $mail = new Zend_Mail();
            $mail->setBodyText($bodyMessage);
            $mail->setFrom($this->_contactMail->getFrom(), $this->_contactMail->getName());
            $mail->addTo($this->_contactMail->getFrom());
            $mail->setSubject($this->_contactMail->getSubject());
            
            $mail->send();
            
            return true;
        } catch (Exception $e) {
            throw new Zend_Exception("Site Contact Mail Error \n" . $e->getMessage());
        }
        
    }

}

?>
