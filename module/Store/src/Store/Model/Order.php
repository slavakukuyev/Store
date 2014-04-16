<?php

namespace Store\Model;
// I don't have the filters here now I can implement the Interface
// Use with Zend\Db\ResultSet\ResultSet. You send it as argument to the Adapter ot TableDataGateway
/*
The form’s bind() method attaches the model to the form. This is used in two ways:

When displaying the form, the initial values for each element are extracted from the model.
After successful validation in isValid(), the data from the form is put back into the model.
These operations are done using a hydrator object. There are a number of hydrators, but the default 
one is Zend\Stdlib\Hydrator\ArraySerializable which expects to find two methods in the model: 
getArrayCopy() and exchangeArray(). We have already written exchangeArray() in our Album entity, 
so just need to write getArrayCopy():
*/
class Order // implements ArrayObject - but I should define a lot of methods
{
    public $id;
    public $productid;
    public $price;
    public $count;        
    public $userid;        
    public $ordered;        
    public $status;            

        // ArrayObject, or at least implement exchangeArray. For Zend\Db\ResultSet\ResultSet to work
        // 1) hydration!!!!! <- This is enough for resultSet to work but not for the form
    public function exchangeArray($data) 
    {
        $this->id     = (!empty($data['id'])) ? $data['id'] : null;
        $this->productid     = (!empty($data['productid'])) ? $data['productid'] : null;        
        $this->price     = (!empty($data['price'])) ? $data['price'] : null;
        $this->count     = (!empty($data['count'])) ? $data['count'] : null;
        $this->userid     = (!empty($data['userid'])) ? $data['userid'] : null;
        $this->ordered     = (!empty($data['ordered'])) ? $data['ordered'] : null;
        $this->status     = (!empty($data['status'])) ? $data['status'] : 1;
    }
        
        // 2) Extraction. For extraction the standard Hydrator the Form expects getArrayCopy to be able to bind
        // -> Extracts the data
    // Add the following method:
    public function getArrayCopy()
    {
        return get_object_vars($this);
    }        
}