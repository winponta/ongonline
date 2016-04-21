<?php

/**
 * newAgana PHPClass
 *
 * @category   Agana
 * @package    Agana_View_Helper
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_View_Helper_ExternalLink extends Zend_View_Helper_Abstract {

    public function externalLink($url, $title = null, $addIconClass = true) {
        $html = '';

        if ($url) {
            $html = '<a href="' . $url . '" target="_blank">';
            if ($title) {
                $html .= $title;
            } else {
                $html .= $url;
            }

            if ($addIconClass) {
                $html .= '&nbsp;<i class="icon-external-link" style="font-size:0.85em"></i>';
            }
            $html .= "</a>";
        }

        return $html;
    }

}
