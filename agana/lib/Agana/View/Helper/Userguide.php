<?php

/**
 * Agana_View_Helper_Userguide
 * Auxiliar da Camada de Visualização
 * 
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_Userguide extends Zend_View_Helper_Abstract {
    
    public function userguide() {
        return $this;
    }
    
    public function getUrl($page) {
        return $this->view->url(array(
            'module' => 'aganacore',
            'controller' => 'userguide',
            'action' => 'get',
            'page' => $page
        ), 'default', true);
    }
    
    public function getLink($page, $options=array()) {
        $options['text'] = (isset($options['text'])) ? $options['text'] : '';
        $options['icon'] = (isset($options['icon'])) ? $options['icon'] : 'icon-question-sign';
        $options['class'] = (isset($options['class'])) ? $options['class'] : 'pull-right';
        $options['class'] .= ' system-help';
        $options['engine'] = (isset($options['engine'])) ? $options['engine'] : 'colorbox-system-help';
        
        $link = '<a';
        $link .= ' class="'.$options['class'].'" ';
        $link .= ' rel="'.$options['engine'].'" ';
        //$link .= ' load-in="content-container" ';
        $link .= ' href="'. $this->getUrl($page).'">';
        $link .= ' <i class="'.$options['icon'].'"></i>';
        $link .= ' <translate>'.$options['text'].'</translate>';
        $link .= ' </a>';
        
        return $link;
    }
}
