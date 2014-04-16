<?php

namespace Store\Form;

use Zend\Form\Form;

class RegistrationForm extends Form {

    public function __construct($name = null) {
        parent::__construct('registration');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'firstname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'First Name',
            ),
        ));

        $this->add(array(
            'name' => 'lastname',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Last Name',
            ),
        ));



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
            'name' => 'password',
            'attributes' => array(
                'type' => 'password',
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'birthdate',
            'type' => 'Zend\Form\Element\Date',            
            'options' => array(
                'label' => 'Birth Date'
            ),
            'attributes' => array(
                'min' => '1901-01-01',
                'max' => $this->get18Age(),
                'step' => '1', // days; default step interval is 1 day
            )
        ));


//        $this->add(array(
//            'name' => 'usrPasswordConfirm',
//            'attributes' => array(
//                'type'  => 'password',
//            ),
//            'options' => array(
//                'label' => 'Confirm Password',
//            ),
//        ));        

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
                'value' => 'Go',
                'id' => 'submitbutton',
            ),
        ));
    }

    public function get18Age() {
        return date('Y-m-d', strtotime('-18 year'));
    }

}

?>
