<?php

/**
 * ImgTag view helper returns the img tag with the media 
 *
 * @category   Agana
 * @package    Agana_Media
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_MediaImgTag extends Zend_View_Helper_Abstract {

    public function MediaImgTag($file = null, $size = 'medium', $options = array()) {
        if ($file == null) {
            $pic = $this->view->baseUrl() . $this->view->path_img . '/no-picture.jpg';
        } else {
            $pic = $this->view->url(array(
                'module' => 'media', 'controller' => 'image', 'action' => 'get',
                'file' => $file,
                'size' => $size,
                    ), null, true);
        }
        
        $rel = "";
        if (!($file == null) && isset($options['showpopover']) && $options['showpopover']) {
            $rel = '<i class="icon-search pull-right" rel="popover" '
                    . ' style="color: #fff; background-color: #000; position:relative; margin-top: -15px; opacity: 0.7;"'
                    . ' data-original-title=""'
                    . ' data-content="<img src=\''.$pic.'\' />"'
                    . ' ></i>'; 
        }

        $width =  (isset($options['width'])) ? $options['width'] : '';
        $height =  (isset($options['height'])) ? $options['height'] : '';
        
        $style = 'style="';
        $style .= 'width: '. $width . 'px; ';
        $style .= ' height: '. $height . 'px; ';
        $style .= '"';
        
        $tag = '<img src = "'. $pic .'"';
        $tag .= " " . $style;
//        $tag .= " " . $rel;
        $tag .= ' />';
        
        return $tag . $rel;
    }

}
