<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * This class represents a comment related to a blog post.
 * @ORM\Entity(repositoryClass="Application\Repository\PrivilegesRepository")
 * @ORM\Table(name="privileges")
 */
class Privileges
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
    /*
     * @ManyToMany(targetEntity="Level", mappedBy="privs")
     */
    protected $levels;

    public function __construct() {
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
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
}
