<?php



namespace Store\Form; 

use Zend\Captcha; 
use Zend\Form\Element; 
use Zend\Form\Form; 

class PersonalDetailsForm extends Form 

{ 
    public function __construct($name = null) 
    { 
        parent::__construct('personalDetails');         
        //$this->setAttribute('method', 'post');        
        
        $this->add(array( 
            'name' => 'id', 
            'type' => 'Zend\Form\Element\Hidden',                         
        )); 
 
        $this->add(array( 
            'name' => 'email', 
            'type' => 'Zend\Form\Element\Email', 
            'attributes' => array(                 
               
                'readonly'=>true,
            ), 
            'options' => array( 
                'label' => 'Email',               
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'firstname', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'First Name', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'First Name', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'lastname', 
            'type' => 'Zend\Form\Element\Text', 
            'attributes' => array( 
                'placeholder' => 'Last Name', 
                'required' => 'required', 
            ), 
            'options' => array( 
                'label' => 'Last Name', 
            ), 
        )); 
 
        $this->add(array( 
            'name' => 'birthdate', 
            'type' => 'Zend\Form\Element\Date', 
            'attributes' => array( 
                'placeholder' => 'BirthDate', 
                'required' => 'required', 
                'min' => '1901-01-01', 
                'max' => date('Y-m-d', strtotime('-18 year')), 
                'step' => '1', 
            ), 
            'options' => array( 
                'label' => 'Birth Date', 
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
                'value' => 'Edit_Personal_Details',
                'id' => 'submitbutton',
            ),
        ));
    } 
} 
?>
