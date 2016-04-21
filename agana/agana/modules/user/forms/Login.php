<?php

/**
 * LoginForm
 *
 * @category   Agana
 * @package    Agana_LoginForm
 * @copyright  Copyright (c) 2011-2011 Winponta Software (http://www.winponta.com.br)
 * @author Ademir Mazer Jr (Nuno Mazer) <http://ademir.winponta.com.br>
 */
class User_Form_Login extends Zend_Form {

    public function init() {
        $this->setName("login");
        $this->setMethod('post');

        $this->addElement(
            'text', 'name', array(
                'filters' => array('StringTrim', 'StringToLower'),
                'validators' => array(
                    array('StringLength', false, array(0, 50)),
                ),
                'required' => true,
                'label' => 'User name',
                'title' => $this->getTranslator()->_('Your user name identification')
            )
        );

        $this->addElement(
            'password', 'pwd', array(
                'filters' => array('StringTrim'),
                'validators' => array(
                    array('StringLength', false, array(0, 50)),
                ),
                'required' => true,
                'label' => _('Password'),
            )
        );

        $this->addDisplayGroup(
            array(
                'name', 'pwd'
            ), 'logingroup', 
            array('legend' => 'User authentication')
        );

        $this->addElement(
            'submit', 'btnLogin', array(
                'required' => false,
                'ignore' => true,
                'label' => 'Login',
            )
        );

        $forgot = new Agana_Form_Element_Html('forgotPwd');
        $forgot->setValue($this->getTranslator()->_('Forgot your password? You can ask for reset it.') . ' <a href="reset-password"><translate>Reset password</translate></a>');
//        $forgot->s('Forgot your password? You can ask for reset it.');
//        $forgot->setDecorators(array(
//            array('Label', array('tag' => 'dt', 'class' => 'note_label'))
//        ));
        $this->addElement($forgot);

//        $token = new Zend_Form_Element_Hash('token');
//        $token->setSalt(md5(uniqid(rand(), TRUE)));
//        $token->setTimeout(30);
//        $this->addElement($token);
    }

}
