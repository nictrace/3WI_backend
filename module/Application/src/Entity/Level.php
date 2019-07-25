<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents access levels
 * @ORM\Entity()
 * @ORM\Table(name="level")
 */
class Level
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
     * @ORM\ManyToMany(targetEntity="Privileges", inversedBy="levels")
     * @ORM\JoinTable(name="level_priv", joinColumns={@ORM\JoinColumn(name="level", referencedColumnName="id")},
	    inverseJoinColumns={@ORM\JoinColumn(name="priv", referencedColumnName="id")})
     */
    protected $privs;

    public function __construct() {
        $this->privs = new ArrayCollection();
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
    public function getPrivs(){
	return $this->privs;
    }
}
