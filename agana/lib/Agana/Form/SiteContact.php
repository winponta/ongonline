<?php

/**
 * SiteContact Form
 *
 * @category   Aganacore
 * @package    Agana_SiteContact
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class Agana_Form_SiteContact extends Zend_Form {

    public $_selectOptions;

    public function init() {
        $this->setName('formSiteContact');
        $this->setMethod('post');
        $this->setLegend('Contact Form');
//        $this->setDecorators(array(
//            'FormElements',
//            array(
//                'TabContainer',
//                array(
//                    'id' => 'tabContainer',
//                    'style' => 'width:660px; height:500px',
//                    'dijitParams' => array(
//                        'tabPosition' => 'top',
//                    )
//                ),
//                'DijitForm'
//            )
//        ));

//        $textForm = new Zend_Dojo_Form_SubForm();
//        $textForm->setAttribs(array(
//            'name' => 'textboxtab',
//            'legend' => 'Text Elements',
//            'dijitParams' => array(
//                'title' => 'Text Elements',
//            )
//        ));

        $this->addElement(
            'text', 'name', array(
            'label' => 'Your Name',
            'trim' => true,
            'required' => true,
        ));

        $email = new Zend_Form_Element_Text('from');
        $email->setLabel('Your Email')
                ->addFilters(array('StringTrim', 'StripTags'))
                ->setRequired(true)
                ->addValidator('EmailAddress');
        $this->addElement($email);

        $this->addElement(
            'text', 'subject', array(
            'label' => 'Subject',
            'required' => true,
//            'regExp' => '[\w]+',
//            'invalidMessage' => 'invalid non-space text.',
                )
        );

        $this->addElement(
            'Textarea', 'message', array(
            'label' => 'Your Message',
            'required' => true,
            //'style' => 'width:200px',
                )
        );

        $this->addDisplayGroup(
                array('name', 'from', 'subject', 'message'),
                'formSiteContactGroup',
                array('legend' => 'Contact Form')
        );

        $this->addElement(
            'Submit', 'submit', array(
            'label' => 'Send',
            'required' => false,
            'ignore' => true,
            //'style' => 'width:200px',
                )
        );


    }
}