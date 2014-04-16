<?php

namespace Store\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class AddressFilter extends InputFilter {

    public function __construct($sm) {
        // self::__construct(); // parnt::__construct(); - trows and error
        
        $this->add(array(
                    'name' => 'cities', 
            'filters' => array( 
                array('name' => 'StripTags'), 
                array('name' => 'StringTrim'), 
            ),            
        ));

        $this->add(array(
           'name' => 'street', 
            'required' => true, 
            'filters' => array( 
                array('name' => 'StripTags'),                 
            ), 
            'validators' => array(                 
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 1,
                        'max' => 150,
                    ),
                ),
            ), 
        ));
        $this->add(array(
            'name' => 'phone1',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 9,
                        'max' => 15,
                    ),
                ),
            ),
        ));
        
         $this->add(array(
            'name' => 'phone2',
            'required' => true,
            'filters' => array(
                array('name' => 'StripTags'),
                array('name' => 'StringTrim'),
            ),
            'validators' => array(
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'encoding' => 'UTF-8',
                        'min' => 9,
                        'max' => 15,
                    ),
                ),
            ),
        ));
    }

}