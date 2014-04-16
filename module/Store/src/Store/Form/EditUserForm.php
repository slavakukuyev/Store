<?php

namespace Store\Form;

use Zend\Form\Form;

class EditUserForm extends Form {

    public function __construct($name = null) {
        parent::__construct('edituser');
        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => true,
            ),
            'options' => array(
                'label' => 'ID',
            ),
        ));



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
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        $this->add(array(
            'name' => 'email',
            'attributes' => array(
                'type' => 'email',
                'readonly' => true,
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));


        $this->add(array(
            'name' => 'registered',
            'attributes' => array(
                'type' => 'text',
                'readonly' => true,
            ),
            'options' => array(
                'label' => 'Registered DateTime:',
            ),
        ));
        
          $this->add(array(
            'name' => 'balance',
            'attributes' => array(
                'type' => 'label',
                'readonly' => true,
            ),
            'options' => array(
                'label' => 'balance',
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



        $this->add(array(
            'name' => 'isadmin',
            'attributes' => array(
                'type' => 'email',
                'readonly' => true,
            ),
            'options' => array(
                'label' => 'E-mail',
            ),
        ));

      $this->add(array(
             'type' => 'Zend\Form\Element\Radio',
             'name' => 'enabled',
             'options' => array(
                     'label' => 'Is Enabled ?',
                     'value_options' => array(
                             '0' => 'Disabled',
                             '1' => 'Enabled',
                     ),
             )
     ));

        
        
     
     $this->add(array(
             'type' => 'Zend\Form\Element\Radio',
             'name' => 'isadmin',
             'options' => array(
                     'label' => 'Is Admin ?',
                     'value_options' => array(
                             '0' => 'Regular User',
                             '1' => 'Admin',
                     ),
             )
     ));



        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Edit',
                'id' => 'editusersubmit',
            ),
        ));
    }

    private function get18Age() {
        return date('Y-m-d', strtotime('-18 year'));
    }

}