<?php

namespace Store\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class PasswordForm extends Form {

    public function __construct($name = null) {
        parent::__construct('changePassword');
        $this->setAttribute('method', 'post');



        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Old Password',
            ),
            'options' => array(
                'label' => 'Old password',
            ),
        ));

        $this->add(array(
            'name' => 'newPassword',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'New Password',
            ),
            'options' => array(
                'label' => 'New password',
            ),
        ));

        $this->add(array(
            'name' => 'confirmPassword',
            'attributes' => array(
                'type' => 'password',
                'placeholder' => 'Confirm Password',
            ),
            'options' => array(
                'label' => 'Confirm password',
            ),
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Change Password',
                'id' => 'submitpassword',
            ),
        ));
    }

}