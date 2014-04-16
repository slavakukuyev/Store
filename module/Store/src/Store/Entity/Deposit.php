<?php

namespace Store\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * Deposit
 *
 * @ORM\Table(name="deposit")
 * @ORM\Entity(repositoryClass="Store\Entity\Repository\UserRepository")
 * @Annotation\Name("deposit")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Deposit {
    //fields------------------

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var bigint
     *
     * @ORM\Column(name="userid", type="integer", nullable=false)
     */
    private $userid;
    
       
        
    /**
     * @var string
     *
     * @ORM\Column(name="creditcard", type="text", nullable=false)
     */
    private $creditcard;
    
    /**
     * @var string
     *
     * @ORM\Column(name="cvv", type="text" , nullable=false)
     */
    private $cvv;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="amount", type="text", nullable=false)
     */
    private $amount;
    
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="deposited", type="text", nullable=false)
     */
    private $deposited;
    
    
     //end fields------------------

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) {
        $this->$property = $value;
    }

    public function getArrayCopy() {
        return get_object_vars($this);
    }
    
    public function populate($data = array()) {
        $this->id = isset($data['id']) ? $data['id'] : NULL;
        $this->userid = $data['userid'];
        $this->creditcard = $data['creditcard'];
        $this->cvv = $data['cvv'];
        $this->deposited = isset($data['deposited']) ? $data['deposited'] : date('Y-m-d H:i:s');
        $this->amount = isset($data['amount']) ? $data['amount'] : 0;        
        
    }
    

}
?>