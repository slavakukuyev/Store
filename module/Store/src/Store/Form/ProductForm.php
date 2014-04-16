<?php

namespace Store\Form;

use Zend\Captcha;
use Zend\Form\Element;
use Zend\Form\Form;

class ProductForm extends Form {

    public function __construct($name = null) {
        parent::__construct('product_form');
        $this->setAttribute('method', 'post');
        
        
         $this->add(array(
            'name' => 'id',
            'attributes' => array(
                'type' => 'text',
                'readonly' => true,
                'style'=>'border:none;'
            ),
            'options' => array(
                'label' => 'ID',
            ),
        ));

         
          $this->add(array(
            'name' => 'categoryid',
            'attributes' => array(
                'type' => 'hidden',
            ),           
        ));
          
          
           $this->add(array(
            'name' => 'categories',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(                
            ),
            'options' => array(
                'label' => 'Categories',
                'value_options' => array(
                ),
            ),
        ));


        $this->add(array(
            'name' => 'brand',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Brand',
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'style'=>'width:400px;'
            ),
            'options' => array(
                'label' => 'Title',
            ),
        ));
        
        
        $this->add(array(
            'name' => 'price',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Price',
            ),
        ));
        
         $this->add(array(
            'name' => 'price_opt',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'Price Opt',
            ),
        ));
         
          $this->add(array(
            'name' => 'instock',
            'attributes' => array(
                'type' => 'text',
            ),
            'options' => array(
                'label' => 'InStock',
            ),
        ));
        
        
        
        
        
         $this->add(array(
            'name' => 'description',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Textarea',
                'cols'=>'100',
                'rows'=>'10'
            ),
            'options' => array(
                'label' => 'Description',
            ),
        ));
         
          $this->add(array(
            'name' => 'image_image',
            'attributes' => array(
                'type' => 'Zend\Form\Element\Image',
                
            ),
            'options' => array(
                'label' => 'Image',
            ),
        ));
          
             $this->add(array(
            'name' => 'image',
            'attributes' => array(
                'type' => 'hidden',
                
            ),            
        ));
        

         
         // Element\Image
         
        $this->add(array(
            'name' => 'csrf',
            'type' => 'Zend\Form\Element\Csrf',
        ));

        
           $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Edit',
                'id' => 'productsubmit',
            ),
        ));
        
        
        
        
    }
    
}