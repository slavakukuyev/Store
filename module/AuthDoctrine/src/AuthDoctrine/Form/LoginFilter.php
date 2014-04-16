<?php

namespace AuthDoctrine\Form;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class LoginFilter extends InputFilter {

    public function __construct($sm) {
        
        
        $this->add(array(
                        'name'     => 'email', // 'usr_name'
                        'required' => true,
                        'filters'  => array(
                                array('name' => 'StripTags'),
                                array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                                array(
                                        'name'    => 'StringLength',
                                        'options' => array(
                                                'encoding' => 'UTF-8',
                                                'min'      => 1,
                                                'max'      => 100,
                                        ),
                                ),
                                array(
                                        'name'                => 'DoctrineModule\Validator\ObjectExists',
                                        'options' => array(
                                                'object_repository' => $sm->get('doctrine.entitymanager.orm_default')->getRepository('AuthDoctrine\Entity\User'),
                                                'fields'            => 'email',
                                        ),
                                        
                                ),
                        ), 
                ));
        
        
         $this->add(array(
                        'name'     => 'password', // usr_password
                        'required' => true,
                        'filters'  => array(
                                array('name' => 'StripTags'),
                                array('name' => 'StringTrim'),
                        ),
                        'validators' => array(
                                array(
                                        'name'    => 'StringLength',
                                        'options' => array(
                                                'encoding' => 'UTF-8',
                                                'min'      => 6,
                                                'max'      => 12,
                                        ),
                                ),
                        ),
                ));                
        
        
    }

}


?>
