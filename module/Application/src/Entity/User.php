<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents users
 * @ORM\Entity()
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="name", type="string")
     */
    protected $name;
    /**
     * @ORM\Column(name="phone", type="string")
     */
    protected $phone;
    /**
     * @ORM\Column(name="mail", type="string")
     */
    protected $mail;
    /**
     * @ORM\Column(name="pass", type="string")
     */
    protected $pass;
    /**
     * @ORM\Column(name="created", type="datetime")
     */
    protected $created;

    public function __construct() {
//        $this->privs = new ArrayCollection();
    }

    public function getId()
    {
	return $this->id;
    }
    public function getName()
    {
	return $this->name;
    }
    public function setName($val)
    {
	$this->name = $val;
	return $this;
    }
    public function getPhone(){
	return $this->phone;
    }
    public function setPhone($val){
	$this->phone = $val;
	return $this;
    }
    public function getCreated(){
	return $this->created;
    }
    public function setCreated($val){
	$this->created = $val;
	return $this;
    }
    public function check_pass($pass){
        if($this->pass == $pass) return true;
        else return false;
    }
}
