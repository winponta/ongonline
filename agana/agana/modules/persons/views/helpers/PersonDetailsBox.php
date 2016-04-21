<?php

/**
 * Returns detail box to be showed in a modal or other overlay
 * May be configured to return several types of information, dependent of
 * another modules
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2013-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Person_View_Helper_PersonDetailsBox extends Zend_View_Helper_Abstract {

    /**
     * Return self object to provide access to another methods in view call
     * 
     * @return \Person_View_Helper_PersonDetailsBox
     */
    public function personDetailsBox() {
        return $this;
    }

    /**
     * Receives an id or Persons_Model_Person and returns the 
     * details box complete tag. By default rel param is seted to popover
     * 
     * @param int || Persons_Model_Person
     * @param String $imgSize The image size to be returned
     * @param array $params Img tag params
     * @return String
     */
    public function getBox($person, $imgSize = 'tiny', $params = null) {
        $box = '<div class="container-fluid">';
        $box .= '<div class="row-fluid">';
        
        $person = $this->getPerson($person);
        
        $box .= '<div class="span12">';
        $box .= '<h4>' . str_replace($person->getName(), "'", "&amp") . '</h4>';
        $box .= '</div>';

        $box .= '<div class="span7">';
        $box .= '';
        $box .= '</div>';

        $box .= '<div class="span4">';
        $imgHelper = $this->view->personPicture();
        $box .= $imgHelper->getTag($person, $imgSize, $params);
        $box .= '</div>';
        
        $box .= '</div>';
        $box .= '</div>';

        return $box;
    }

    private function getPerson($person) {
        if (is_numeric($person)) {
            $domain = new Persons_Domain_Person();
            $person = $domain->getById($person);
        }

        if (is_a($person, 'Persons_Model_Person')) {
            return $person;
        } else {
            throw new Exception('No valid person passed to PersonDetailsBox helper');
        }
    }
}