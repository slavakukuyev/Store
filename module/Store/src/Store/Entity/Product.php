<?php

namespace Store\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * Users
 *
 * @ORM\Table(name="products")
 * @ORM\Entity(repositoryClass="Store\Entity\Repository\ProductRepository")
 * @Annotation\Name("product")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class Product {
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
     * @ORM\Column(name="brand", type="text",  nullable=false)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text",  nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text",  nullable=false)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="text",  nullable=false)
     */
    private $price;
    
    
    /**
     * @var string
     *
     * @ORM\Column(name="price_opt", type="text",  nullable=false)
     */
    private $price_opt;

    /**
     * @var string
     *
     * @ORM\Column(name="image", type="text",  nullable=false)
     */
    private $image;

    /**
     * @var string
     *
     * @ORM\Column(name="categoryid", type="text",  nullable=false)
     */
    private $categoryid;

    /**
     * @var string
     *
     * @ORM\Column(name="instock", type="text",  nullable=false)
     */
    private $instock;

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

    function update_instock($count) {
        if($this->instock < $count){
            return false;
        }
        $this->instock = (int) $this->instock - (int) $count;
        return true;
    }
    
    function populate($data=null){
        $this->id=isset($data['id'])? $data['id']:null;
        $this->brand=isset($data['brand'])? $data['brand']:'brand';
        $this->title=isset($data['title'])? $data['title']:'title';
        $this->description=isset($data['description'])? $data['description']:'description';
        $this->price=isset($data['price'])? $data['price']:0;
        $this->price_opt=isset($data['price_opt'])? $data['price_opt']:0;
        $this->image=isset($data['image'])? $data['image']:'';
        $this->categoryid=isset($data['categoryid'])? $data['categoryid']:1;
        $this->instock=isset($data['instock'])? $data['instock']:0;
    }

}

?>
