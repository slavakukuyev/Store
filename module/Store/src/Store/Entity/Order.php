<?php

namespace Store\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * Orders
 *
 * @ORM\Table(name="orders")
 * @ORM\Entity(repositoryClass="Store\Entity\Repository\OrderRepository")
 * @Annotation\Name("order")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Order {
    //fields------------------

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string
     *
     * @ORM\Column(name="productid", type="text")
     */
    private $productid;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="text")
     */
    private $price;

    /**
     * @var string
     *
     * @ORM\Column(name="count", type="text")
     */
    private $count;

    /**
     * @var string
     *
     * @ORM\Column(name="userid", type="text")
     */
    private $userid;

    /**
     * @var string
     *
     * @ORM\Column(name="ordered", type="text")
     */
    private $ordered;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="text")
     */
    private $status;

    public function __get($property) {
        return $this->$property;
    }

    public function __set($property, $value) {
        $this->$property = $value;
    }
    
    public function populate($data = array()){                
        $this->id=isset($data['id'])?$data['id']:null;
        $this->productid=isset($data['productid'])?$data['productid']:null;
        $this->price=isset($data['price'])?$data['price']:null;
        $this->count=isset($data['count'])?$data['count']:null;
        $this->userid=isset($data['userid'])?$data['userid']:null;
        $this->ordered=isset($data['ordered'])?$data['ordered']:date('Y-m-d H:i:s');
        $this->status=isset($data['status'])?$data['status']:1;
        
    }
    
    
      public function getArrayCopy() {
        return get_object_vars($this);
    }

}

?>