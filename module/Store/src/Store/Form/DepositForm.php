<?php

namespace Store\Form;

use Zend\Form\Form;

class DepositForm extends Form {

    public function __construct($name = null) {

        parent::__construct('deposit');
        $this->setAttribute('method', 'post');
        
        
        $this->add(array(
            'name' => 'userid',
            'type' => 'Zend\Form\Element\Hidden',
        ));
        
          $this->add(array(
            'name' => 'amount',
            'attributes' => array(
                'type' => 'text',
                'value' => '',
            ),
            'options' => array(
                'label' => 'Amount',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'creditcard',
            'attributes' => array(
                'type' => 'text',
                'value' => '',
            ),
            'options' => array(
                'label' => 'Credit Card',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'cvv',
            'attributes' => array(
                'type' => 'text',
                'value' => '',
            ),
            'options' => array(
                'label' => 'CVV',
            ),
        ));
        
        


      

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Deposit',
                'id' => 'submitdeposit',
            ),
        ));
    }

}

?>