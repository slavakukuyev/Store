<?php

namespace Store\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Zend\Form\Annotation;

/**
 * Users
 *
 * @ORM\Table(name="users")
 * @ORM\Entity(repositoryClass="Store\Entity\Repository\UserRepository")
 * @Annotation\Name("user")
 * @Annotation\Hydrator("Zend\Stdlib\Hydrator\ClassMethods")
 */
class User {
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
     * @ORM\Column(name="email", type="string", length=255,  nullable=false)
     */
    private $email;

    /**
     * @var bigint
     *
     * @ORM\Column(name="password", type="bigint", length=50,  nullable=false)
     */
    public $password;

    /**
     * @var bigint
     *
     * @ORM\Column(name="addressid", type="bigint", length=11,  nullable=true)
     */
    public $addressid;

    /**
     * @var string
     *
     * @ORM\Column(name="firstname", type="string", length=50,  nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(name="lastname", type="text", nullable=false)
     */
    private $lastname;

    /**
     * @var string
     *
     * @ORM\Column(name="birthdate", type="text", nullable=false)
     */
    private $birthdate;

    /**
     * @var string
     *
     * @ORM\Column(name="registered", type="text", nullable=false)
     */
    private $registered;

    /**
     * @var string
     *
     * @ORM\Column(name="balance", type="text", nullable=false)
     */
    private $balance;

    /**
     * @var string
     *
     * @ORM\Column(name="isadmin", type="text", nullable=false)
     */
    private $isadmin;

    /**
     * @var string
     *
     * @ORM\Column(name="enabled", type="text", nullable=false)
     */
    private $enabled;

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
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->birthdate = $data['birthdate'];
        $this->registered = date('Y-m-d H:i:s');
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->enabled = isset($data['enabled']) ? $data['enabled'] : 1;
        $this->balance = isset($data['balance']) ? $data['balance'] : 0;
        $this->isadmin = isset($data['isadmin']) ? $data['isadmin'] : 0;
        $this->addressid = isset($data['addressid']) ? $data['addressid'] : NULL;
    }

    public function order($data = array()) {
        if (isset($data['price'])) {
            if ((int) $this->balance >= (int) $data['price']) {
                $this->balance -=$data['price'];
            }
            else
                return false;
        }
        return $this;
    }

    public function pd($data = array()) {
        $this->firstname = $data['firstname'];
        $this->lastname = $data['lastname'];
        $this->birthdate = $data['birthdate'];
        
        $this->isadmin = isset($data['isadmin'])?$data['isadmin']:0;
         $this->enabled = isset($data['enabled'])?$data['enabled']:1;
         
          $this->birthdate = $data['birthdate'];
    }

    public function newPassword($data = array()) {

        if ($this->password === md5($this->email . $data['password'] . $this->registered)) {
            $password = md5($this->email . $data['newPassword'] . $this->registered);
            $this->password = $password;
            return $this;
        } else {
            return false;
        }
    }    
    
}

?>
