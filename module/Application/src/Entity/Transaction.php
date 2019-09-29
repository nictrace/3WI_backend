<?php
namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * This class represents users
 * @ORM\Entity(repositoryClass="Application\Repository\TransactionsRepository")
 * @ORM\Table(name="transaction")
 */
class Transaction
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="user_id", type="integer")
     */
    protected $userId;
    /**
     * @ORM\Column(name="container_id", type="integer")
     */
    protected $containerId;
    /**
     * @ORM\Column(name="weight", type="decimal")
     */
    protected $weight;
    /**
     * @ORM\Column(name="scrap_class", type="string")
     */
    protected $scrapClass;
    /**
     * @ORM\Column(name="timestamp", type="datetime")
     */
    protected $timestamp;

    public function __construct() {
//        $this->privs = new ArrayCollection();
    }

    public function getId()
    {
	return $this->id;
    }
    public function getUserId()
    {
	return $this->userId;
    }
    public function setUserId($val)
    {
	$this->userId = $val;
	return $this;
    }
    public function getContainerId(){
	return $this->containerId;
    }
    public function setContainerId($val){
	$this->containerId = $val;
	return $this;
    }
    public function getTimestamp(){
	return $this->timestamp;
    }
    public function setTimestamp($val){
	$this->timestamp = $val;
	return $this;
    }
    public function getWeight(){
        return $this->weight;
    }
    public function setWeight($val){
        $this->weight = $val;
        return $this;
    }
    public function getScrapClass(){
        return $this->scrapClass;
    }
    public function setScrapClass($val){
        $this->scrapClass = $val;
        return $this;
    }
    public function toArray(){
	$out = [];
	$out['id'] = $this->getId();
	$out['user_id'] =  $this->getUserId();
	$out['container_id'] = $this->getContainerId();
	$out['timestamp'] = $this->getTimestamp();
	$out['weight'] = $this->getWeight();
	$out['scrap_class'] = $this->getScrapClass();
	return $out;
    }
}
