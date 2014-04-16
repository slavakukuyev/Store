<?php

namespace Store\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class DepositFilter extends InputFilter {

    public function __construct($sm) {



        $this->add(array(
            'name' => 'creditcard',
            'required' => true,
             'filters' => array(
                array('name' => 'Digits'),
            ),
//            'filters' => array(
//                array('name' => 'Zend\Validator\CreditCard'),
//            ),
            'validators' => array(
                array(
                    'name' => 'Zend\Validator\CreditCard',
                    'options' => array(
                        'type' => 'All',
                        
                    ),
                ),
            ),
        ));


        $this->add(array(
            'name' => 'cvv',
            'required' => true,
            'filters' => array(
                array('name' => 'Digits'),
            ),
            'validators' => array(
//                array(
//                    'name' => 'Between',
//                    'options' => array(
//                        'min' => 1,
//                        'max' => 9999,
//                    ),
//                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 3,
                        'max' => 4,
                    ),
                ),
            ),
        ));



        $this->add(array(
            'name' => 'amount',
            'required' => true,
            'filters' => array(
                array('name' => 'Int'),
            ),
            'validators' => array(
                array(
                    'name' => 'Between',
                    'options' => array(
                        'min' => 500,
                        'max' => 20000,
                    ),
                ),
            ),
        ));
    }

}
?>


