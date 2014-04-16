<?php

namespace CsnUser\Form;

use Zend\Form\Form;

class UserForm extends Form {

    function __construct($name = null) {
        parent::__construct('user');
        $this->setAttribute('method', 'post');
        $this->add(array(
            'name' => 'email',
            'attributes' => array('type' => 'text'),
            'options' => array('label' => 'email'),
                )
        );


        $this->add(array(
            'name' => 'firstname',
            'attributes' => array('type' => 'text'),
            'options' => array('label' => 'firstname'),
                )
        );

        $this->add(array(
            'name' => 'id',
            'attributes' => array('type' => 'text'),
            'options' => array('label' => 'id'),
                )
        );
        
        $this->add(array(
           'name'=>'submitForm',
            'attributes' => array('type' => 'submit','value'=>'submit'),
            
                )
        );
    }

}

?>
