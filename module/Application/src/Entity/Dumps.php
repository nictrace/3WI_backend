<?php
namespace Application\Entity;
use Doctrine\ORM\Mapping as ORM;
/**
 * This class represents a comment related to a blog post.
 * @ORM\Entity(repositoryClass="Application\Repository\DumpsRepository")
 * @ORM\Table(name="dumps")
 */
class Dumps
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue
     */
    protected $id;
    /**
     * @ORM\Column(name="address")
     */
    protected $address;
    /**
     * @ORM\Column(name="lat", type="float")
     */
    protected $lat;
    /**
     *@ORM\Column(name="lon", type="float")
     */
    protected $lon;
    /**
     * @ORM\Column(name="violationtype")
     */
    protected $violationType;
    /**
     * @ORM\Column(name="picture", type="string")
     */
    protected $picture;
    /**
     * @ORM\Column(name="plastic", type="boolean")
     */
    protected $plastic;
    /**
     * @ORM\Column(name="metal", type="boolean")
     */
    protected $metal;
    /**
     * @ORM\Column(name="glass", type="boolean")
     */
    protected $glass;
    /**
     * @ORM\Column(name="paper", type="boolean")
     */
    protected $paper;
    /**
     * @ORM\Column(name="cloth", type="boolean")
     */
    protected $cloth;
    /**
     * @ORM\Column(name="tetrapack", type="boolean")
     */
    protected $tetrapack;
    /**
     * @ORM\Column(name="house_tech", type="boolean")
     */
    protected $houseTech;
    /**
     * @ORM\Column(name="lamps", type="boolean")
     */
    protected $lamps;
    /**
     * @ORM\Column(name="batteries", type="boolean")
     */
    protected $batteries;
    /**
     * @ORM\Column(name="time_on", type="string", options={"default":"00:00:00"})
     */
    protected $timeOn;
    /**
     * @ORM\Column(name="time_off", type="string",  options={"default":"23:59:59"})
     */
    protected $timeOff;
    /**
     * @ORM\Column(name="reporter", type="integer")
     */
    protected $reporter;
    /**
     * @ORM\Column(name="comment", nullable=true)
     */
    protected $comment;
    /**
     * @ORM\Column(name="state", type="string", options={"default":"Новая"})
     */
    protected $state;
    /**
     * @ORM\Column(name="level", type="integer", options={"default":5})
     */
    protected $level;
    /**
     * @ORM\Column(name="price", type="integer", nullable=true)
     */
    protected $price;
    /**
     * @ORM\Column(name="volume", type="integer", nullable=true)
     */
    protected $volume;
//    /**
//     * ORM\ManyToOne(targetEntity="Application\Entity\Post", inversedBy="comments")
//     * ORM\JoinColumn(name="post_id", referencedColumnName="id")
//     */
//    protected $post;

    /**
     * Returns ID of this comment.
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
    /**
     * Sets ID of this comment.
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }
    /**
     * Returns lattitude
     * @return float $lat
     */
    public function getLat()
    {
	return $this->lat;
    }
    /**
     * Set lattitude
     * @param float $newlat
     * @return Entity\Dumps
     */
    public function setLat($newlat)
    {
	$this->lat = $newlat;
	return $this;
    }
    /**
     * Returns longitude
     * @return float $lon
     */
    public function getLon()
    {
	return $this->lon;
    }
    /**
     * Set coordinates
     * @param array
     */
    public function setCoordinates($coords)
    {
	if(is_array($coords)){
	    $this->lat = $coords[0];
	    $this->lon = $coords[1];
	}
	return $this;
    }

    /**
     * Set longitude
     * @param float $newlon
     * @return Entity\Dumps
     */
    public function setLon($newlon)
    {
        $this->lon = $newlon;
        return $this;
    }
    /**
     * Returns comment text.
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }
    /**
     * Sets comment text.
     * @param string $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }
    /**
     * Returns violation type.
     * @return string
     */
    public function getViolationType()
    {
	return $this->violationType;
    }
    /**
     * Sets violation type
     * @param string $val
     */
     public function setViolationType($val)
    {
	$this->violationType = $val;
	return $this;
    }
    /**
     * Returns images array
     * @return array
     */
    public function getPicture()
    {
	$p = $this->picture;
        if(strlen($p) == 0) return [];
	$ap = explode(',', $p);
	foreach($ap as &$i){
	  $i.='.jpg';
	}
	return $ap;
    }
    /**
     * Returns bool plastic
     * @return boolean
     */
    public function getPlastic()
    {
	return $this->plastic;
    }
    /**
     * Sets plastic boolean
     * @param boolean $val
     */
    public function setPlastic($val)
    {
	$this->plastic = $val;
	return $this;
    }
    /**
     * Returns bool metal
     * @return boolean
     */
    public function getMetal()
    {
        return $this->metal;
    }
    /**
     * Sets metal boolean
     * @param boolean $val
     */
    public function setMetal($val)
    {
	$this->metal = $val;
	return $this;
    }
    /**
     * Returns bool glass
     * @return boolean
     */
    public function getGlass()
    {
        return $this->glass;
    }
    /**
     * Sets glass boolean
     * @param boolean $val
     */
    public function setGlass($val)
    {
	$this->glass = $val;
	return $this;
    }
    public function getPaper()
    {
	return $this->paper;
    }
    public function setPaper($val)
    {
	$this->paper = $val;
	return $this;
    }
    public function getCloth()
    {
	return $this->cloth;
    }
    public function setCloth($val)
    {
	$this->cloth = $val;
	return $this;
    }
    public function getTetrapack()
    {
	return $this->tetrapack;
    }
    public function setTetrapack($val)
    {
	$this->tetrapack = $val;
	return $this;
    }
    public function getHouseTech()
    {
	return $this->houseTech;
    }
    public function setHouseTech($val)
    {
	$this->houseTech = $val;
	return $this;
    }
    public function getLamps()
    {
        return $this->lamps;
    }
    public function setLamps($val)
    {
        $this->lamps = $val;
        return $this;
    }
    public function getBatteries()
    {
        return $this->batteries;
    }
    public function setBatteries($val)
    {
        $this->batteries = $val;
        return $this;
    }
    /**
     * Returns the date when this post was created.
     * @return string
     */
    public function getTimeOn()
    {
        return $this->timeOn;
    }

    /**
     * Sets the date when this post was created.
     * @param string $dateCreated
     */
    public function setTimeOn($created)
    {
        $this->timeOn = (string)$created;
    }

    /*
     * Returns renew time
     * @return string
     */
    public function getTimeOff()
    {
        return $this->timeOff;
    }
    /**
     * Sets associated post.
     * param datetime $val
     */
    public function setTimeOff($val)
    {
        $this->timeOff = (string)$val;
        return $this;
    }
    public function getReporter()
    {
	return $this->reporter;
    }
    public function setReporter($val)
    {
	$this->reporter = $val;
	return $this;
    }
    public function getComment()
    {
	return $this->comment;
    }
    public function setComment($val)
    {
	$this->comment = $val;
	return $this;
    }
    public function getState()
    {
	return $this->state;
    }
    public function setState($val)
    {
	$this->state = $val;
	return $this;
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
    public function getPrice()
    {
	return $this->price;
    }
    public function setPrice($val)
    {
	$this->price = $val;
	return $this;
    }
    public function getVolume()
    {
	return $this->volume;
    }
    public function setVolume($val)
    {
	$this->volume = $val;
	return $this;
    }
    public function toArray()
    {
	$out = [];
	$out['id'] = $this->getId();
	$out['coordinates'] = array($this->getLat(), $this->getLon());
        $out['address'] = $this->getAddress();
        $out['violationType'] = $this->getViolationType();
	$out['picture'] = $this->getPicture();	// строка разбитая по запятой
	$out['plastic'] = $this->getPlastic();
	$out['metal'] = $this->getMetal();
        $out['glass'] = $this->getGlass();
	$out['paper'] = $this->getPaper();
	$out['cloth'] = $this->getCloth();
	$out['tetrapack'] = $this->getTetrapack();
	$out['house_tech'] = $this->getHouseTech();
	$out['lamps'] = $this->getLamps();
	$out['batteries'] = $this->getBatteries();
	$out['time_on'] = $this->getTimeOn();
	$out['time_off'] = $this->getTimeOff();
	//$out['reporter'] = $this->getReporter();
	$out['comment'] = $this->getComment();
	$out['state'] = $this->getState();
	$out['level'] = $this->getLevel();
	//$out['price'] = $this->getPrice();
	//$out['volume'] = $this->getVolume();
	return $out;
    }
}
