<?php

namespace Store\Form;

use Zend\Form\Form;

class ForgottenPasswordForm extends Form {

    public function __construct($name = null) {
        parent::__construct('forgotten_password');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));


        $this->add(array(
            'type' => 'Zend\Form\Element\Captcha',
            'name' => 'captcha',
            'options' => array(
                'label' => 'Please verify you are human',
                'captcha' => new \Zend\Captcha\Figlet(),
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Get new password',
                'id' => 'newpasswordbutton',
            ),
        ));
    }

}