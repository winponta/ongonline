<?php

/**
 * Returns img html tag for person id or Persons_Model_Person 
 * If no media is found or no valid param passed then returns img with default
 * no image
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2013-2013 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Person_View_Helper_PersonPicture extends Zend_View_Helper_Abstract {


    /**
     * Return self object to provide access to another methods in view call
     * 
     * @return \Person_View_Helper_PersonPicture
     */
    public function personPicture() {
        return $this;
    }
            
    /**
     * Receives an id or Persons_Model_Person and returns the 
     * img tag
     * 
     * @param int || Persons_Model_Person
     * @param String $size The image size to be returned
     * @param array $params Img tag params
     * @return String
     */    
    public function getTag($person, $size = 'medium', $params = null) {
        $tag = '<img ';

        if (isset($params['class'])) {
            $tag .= 'class="' . $params['class'] . '" ';
        }

        if (isset($params['style'])) {
            $tag .= 'style="' . $params['style'] . '" ';
        }

        if (isset($params['id'])) {
            $tag .= 'id="' . $params['id'] . '" ';
        }

        $tag .= 'src="' . $this->getSourceUrl($person, $size, $params) . '" ';

        $tag .= '>';

        return $tag;
    }

    public function getSourceUrl($person, $size = 'medium', $params = null) {
        if (is_null($person)) {
            $pic = $this->getNoPicture();
        } else {
            if (is_numeric($person)) {
                $domain = new Persons_Domain_Person();
                $person = $domain->getById($person);
            }

            if (is_a($person, 'Persons_Model_Person')) {
                if ($person->getMedia()->file == null) {
                    $pic = $this->getNoPicture();
                } else {
                    $pic = $this->view->url(array(
                        'module' => 'media', 'controller' => 'image', 'action' => 'get',
                        'file' => $person->getMedia()->getFile(),
                        'size' => $size,
                            ), null, true);
                }
            } else {
                $pic = $this->getNoPicture();
            }
        }

        return $pic;
    }

    private function getNoPicture() {
        return $this->view->serverUrl() . $this->view->baseUrl() . $this->view->path_img . '/no-picture.jpg';
    }

}