<?php

namespace Store\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * address
 *
 * @ORM\Table(name="address")
 * @ORM\Entity(repositoryClass="Store\Entity\Repository\AddressRepository")
 * @Annotation\Name("address")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Address {
    //fields------------------

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var bigint
     *
     * @ORM\Column(name="userid", type="bigint", length=11,  nullable=false)
     */
    private $userid;

    /**
     * @var bigint
     *
     * @ORM\Column(name="cityid", type="bigint", nullable=false)
     */
    private $cityid;

    /**
     * @var string
     *
     * @ORM\Column(name="street", type="text", length=255,  nullable=false)
     */
    private $street;

    /**
     * @var string
     *
     * @ORM\Column(name="phone1", type="text", nullable=false)
     */
    private $phone1;

    /**
     * @var string
     *
     * @ORM\Column(name="phone2", type="text", nullable=false)
     */
    private $phone2;

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
        $this->id = isset($data['id'])&&$data['id']!='' ? $data['id'] : NULL;
        $this->userid = $data['userid'];
        $this->cityid = $data['cityid'];
        $this->street = $data['street'];
        $this->phone1 = isset($data['phone1']) ? $data['phone1'] : NULL;
        $this->phone2 = isset($data['phone2']) ? $data['phone2'] : NULL;
    }

}

?>
