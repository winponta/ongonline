<?php

/**
 * Person Search Form
 *
 * @category   Agana
 * @package    Agana_Person
 * @copyright  Copyright (c) 2011-2012 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Persons_Form_PersonSearch extends Agana_Form_Search {

    const ACTION_ADD = 'add';
    const ACTION_EDIT = 'edit';

    /**
     *
     * @var Person_Model_Person
     */
    protected $_model;
    protected $_action;

    public function __construct($model = null, $options = null) {
        $this->_model = $model;
        parent::__construct($options);
        
        $url = new Zend_View_Helper_Url();

        $urlAction = $url->url(array(
            'module'=>'persons',
            'controller'=>'person',
            'action'=>'search'
            ), null, true);
        
        $this->setAction($urlAction);
    }


}
