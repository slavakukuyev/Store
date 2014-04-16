<?php

namespace AuthDoctrine\Form;

use Zend\Form\Form;

class LoginForm extends Form {

    public function __construct($name = null) {

        parent::__construct('login');
        $this->setAttribute('method', 'post');

//        $this->add(array(
//            'name' => 'id',
//            'attributes' => array(
//                'type' => 'hidden',
//            ),
//        ));


        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));

        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'type' => 'passsword',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));


        $this->add(array(
            'name' => 'rememberme',
            'type' => 'checkbox',
            'options' => array(
                'label' => 'Remember me',
            ),
        ));


        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Login',
                'id' => 'submitbutton',
            ),
        ));
    }

}

?>
