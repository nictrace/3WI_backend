<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * This class represents access levels
 * @ORM\Entity()
 * @ORM\Table(name="level_priv")
 */
class LevelPriv
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="level", type="integer")
     */
    protected $level;
    /**
     * @ORM\Column(name="priv", type="integer")
     */
    protected $priv;

    protected $mylevel;

    public function getId()
    {
	return $this->id;
    }
    public function getLevel()
    {
	return $this->level;
    }
    public function setLevel($val)
    {
	$this->level = $val;
	return $this;
    }
    public function getPriv()
    {
	return $this->priv;
    }
    public function setPriv($val)
    {
	$this->priv = $val;
	return $this;
    }
}
