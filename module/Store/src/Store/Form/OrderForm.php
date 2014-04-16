<?php

namespace Store\Form;

use Zend\Form\Form;

class OrderForm extends Form {

    public function __construct($name = null) {

        parent::__construct('order');
        $this->setAttribute('method', 'post');


        $this->add(array(
            'name' => 'productid',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'price',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'userid',
            'type' => 'Zend\Form\Element\Hidden',
        ));

        $this->add(array(
            'name' => 'count',
            'type' => 'Zend\Form\Element\Hidden',
        ));


        $this->add(array(
            'name' => 'counts',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'required' => 'required',
            ),
            'options' => array(
                'label' => 'Count',
                'value_options' => array(
                ),
            ),
        ));




        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Order',
                'id' => 'submitorder',
            ),
        ));
    }

}

?>