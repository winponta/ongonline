<?php

/**
 * The Debug Controller Plugin helps developer to output debug information on
 * html page being worked.
 *
 * @category   Agana Framework
 * @package    Agana_Controller
 * @subpackage Plugins
 * @copyright  Copyright (c) 2011-2011 Winponta - http://www.winponta.com.br
 * @author Ademir Mazer Jr [Nuno Mazer] - <ademir.mazer.jr@gmail.com>
 * 
 */
class Agana_Controller_Plugin_Debug extends Zend_Controller_Plugin_Abstract {

    public function __construct() {
        // register the Agana_Debug obj
        $ad = new Agana_Debug();
        Zend_Registry::set('Agana_Debug', $ad);
    }
    
    public function preDispatch(Zend_Controller_Request_Abstract $request) {
    }
    
    /**
     * Prints out the Agana debug informations
     */
    public function dispatchLoopShutdown() {
        $this->_displayAganaDebug(Agana_Debug::dump($this->getResponse(), 'RESPONSE', false));
    }

    
    /**
     * Appends Debug output html and scripts to the original page
     *
     * @param string $html
     * @return void
     */
    protected function _displayAganaDebug($html)
    {        
//        $front = Agana_Util_Bootstrap::getResource('FrontController');        
//        $router = $front->getRouter();
//        Zend_Registry::get('Agana_Debug')->add($router, 'ROUTER');
//        Zend_Debug::dump($router->getRoute('default'));
//        Zend_Debug::dump($router);
                
        $html = "<div id='Agana_Debug'>";
        
        $html .= Zend_Registry::get('Agana_Debug')->getAll();
        
        $html .= "</div>\n</body>";
        $response = $this->getResponse();
        $response->setBody(str_ireplace('</body>', $html, $response->getBody()));
        
        $libPath = Agana_Util_Bootstrap::getOption('includePaths');
        $libPath = $libPath['library'];
        $js = file_get_contents($libPath . '/Agana/Api/Debug/js/debug.js');
        $js = '<script>' . $js . '</script>';
        $response->appendBody($js);
    }
}

