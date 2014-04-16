<?php

namespace AuthDoctrine\Entity;

use Doctrine\ORM\Mapping as ORM;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Zend\Form\Annotation;


/**
 * Powma\ServiceBundle\Entity\User
 *
 * @ORM\Entity
 * @ORM\Table(name="users")
 */
class User {
    //fields------------------
    
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="album_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;
    
    
    
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

    
    //properties-----------------------------------------
    function set_id($id) {
        $this->id = $id;
        return $this;
    }
    function get_id() {
        return $this->id;
    }
    function set_email($email) {
        $this->email = $email;
        return $this;
    }
    function get_email() {
        return $this->email;
    }
    function set_firstname($firstname) {
        $this->firstname = $firstname;
        return $this;
    }
    function get_firstname() {
        return $this->firstname;
    }
    function set_lastname($lastname) {
        $this->lastname = $lastname;
        return $this;
    }
    function get_lastname() {
        return $this->lastname;
    }
    function set_password($password) {
        $this->password = $password;
        return $this;
    }
    function get_password() {
        return $this->password;
    }
    function set_birthdate($birthdate) {
        $this->birthdate = $birthdate;
        return $this;
    }
    function get_birthdate() {
        return $this->birthdate;
    }
    function set_balance($balance) {
        $this->balance = $balance;
        return $this;
    }
    function get_balance() {
        return $this->balance;
    }
    function set_isadmin($isadmin) {
        $this->isadmin = $isadmin;
        return $this;
    }
    function get_isadmin() {
        return $this->isadmin;
    }
    function set_enabled($enabled) {
        $this->enabled = $enabled;
        return $this;
    }
    function get_enabled() {
        return $this->enabled;
    }
    
    //end properties-----------------------------------
}

?>
