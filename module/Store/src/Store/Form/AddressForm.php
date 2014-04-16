<?php

namespace Store\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class AddressForm extends Form {

    public function __construct($name = null) {
        parent::__construct('Address');

        $this->setAttribute('method', 'post');
        
         $this->add(array(
            'name' => 'id',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
        

        $this->add(array(
            'name' => 'cities',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Cities',
                'value_options' => array(
                ),
            ),
        ));

        $this->add(array(
            'name' => 'cityid',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'userid',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'street',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Type Your street/num',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Street/num',
            ),
        ));

        $this->add(array(
            'name' => 'phone1',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Type your home phone number',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Phone',
            ),
        ));


        $this->add(array(
            'name' => 'phone2',
            'type' => 'Zend\Form\Element\Text',
            'attributes' => array(
                'placeholder' => 'Type your mobile phone number',
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Mobile',
            ),
        ));


        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Edit Address',
                'id' => 'submitaddress',
            ),
        ));
    }

}

?>
