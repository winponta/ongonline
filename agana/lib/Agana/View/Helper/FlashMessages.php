<?php

/**
 * newAgana PHPClass
 *
 * @category   Agana
 * @package    Agana_View_Helper_FlashMessages
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_FlashMessages extends Zend_View_Helper_Abstract {

    protected function _getHtmlPrependMessage($msgType, $class = 'icon-exclamation-sign') {
        return '<div class="alert ' . $msgType . '">' . PHP_EOL .
                '<a class="close" data-dismiss="alert" href="#"><i class="icon-remove-sign"></i></a>' .
                '<i class="' . $class . '"></i>' .
                '<ul>' . PHP_EOL;
    }

    protected function _getHtmlAppendMessage() {
        return '</ul>' . PHP_EOL . '</div>' . PHP_EOL;
    }

    protected function _getTranslatedMsg($message) {
//        if (is_array($message)) {
//            $msg = key_exists('title', $message) ? array_pop($message) : $message;
//        } else {
//            $msg = current($message);
//        }
        
        foreach ($message as $key => $value) {
            if (in_array($key, array('success', 'info', 'warning', 'error', 'validation'))) {
                $msg = $message[$key];
            }
        }
        
        $m = Zend_Registry::get('Zend_Translate')->translate($msg);
        if (key_exists('params', $message)) {
            $args[] = $m;
            if (is_array($message['params'])) {
                $args = $message['params'];
            } else {
                $args[] = $message['params'];
            }
            $m = call_user_func_array('sprintf', $args);
        }

        return $m;
    }

    public function flashMessages($clearMessages = true) {
        $flashMsgHelper = Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        $messages = array_merge(
                $flashMsgHelper->getMessages(), $flashMsgHelper->getCurrentMessages()
        );
        $output = '';

        if (!empty($messages)) {
            $error = '';
            $warning = '';
            $notice = '';
            $success = '';
            $validation = '';

            $q = count($messages);
            for ($index = 0; $index < $q; $index++) {

                $title = key_exists('title', $messages[$index]) ?
                        '<h6 class="title">' . $messages[$index]['title'] . '</h6>' : '';
                if ($title) {
                    $title = Zend_Registry::get('Zend_Translate')->translate($title);
                }
                
                $m = $this->_getTranslatedMsg($messages[$index]);

                if (key_exists('error', $messages[$index])) {
                    //$error .= '<li class="' . key($message) . '">' . current($message) . '</li>';                    
                    $error .= '<li>' . $title . $m . '</li>' . PHP_EOL;
                } else if (key_exists('warning', $messages[$index])) {
                    $warning .= '<li>' . $title . $m . '</li>' . PHP_EOL;
                } else if (key_exists('validation', $messages[$index])) {
                    $validation .= '<li>' . $title . $m . '</li>' . PHP_EOL;
                } else if (key_exists('success', $messages[$index])) {
                    $success .= '<li>' . $title . $m . '</li>' . PHP_EOL;
                } else {
                    $notice .= '<li>' . $title . $m . '</li>' . PHP_EOL;
                }
            }

            $output .= '<div id="app-messages">' . PHP_EOL;
            if ($error !== '') {
                $output .= $this->_getHtmlPrependMessage('alert-error', 'icon-ban-circle') .
                        $error .
                        $this->_getHtmlAppendMessage();
            }
            if ($warning !== '') {
                $output .= $this->_getHtmlPrependMessage('') .
                        $warning .
                        $this->_getHtmlAppendMessage();
            }
            if ($validation !== '') {
                $output .= $this->_getHtmlPrependMessage('') .
                        $validation .
                        $this->_getHtmlAppendMessage();
            }
            if ($success !== '') {
                $output .= $this->_getHtmlPrependMessage('alert-success', 'icon-ok-sign') .
                        $success .
                        $this->_getHtmlAppendMessage();
            }
            if ($notice !== '') {
                $output .= $this->_getHtmlPrependMessage('alert-info', 'icon-info-sign') .
                        $notice .
                        $this->_getHtmlAppendMessage();
            }
            $output .= '</div>';
        }

        if ($clearMessages) {
            $flashMsgHelper->clearMessages('error');
            $flashMsgHelper->clearMessages('notice');
            $flashMsgHelper->clearMessages('warning');
            $flashMsgHelper->clearMessages('success');
            $flashMsgHelper->clearMessages('validation');
            $flashMsgHelper->clearMessages();
            $flashMsgHelper->clearCurrentMessages();
        }

        return $output;
    }

}
