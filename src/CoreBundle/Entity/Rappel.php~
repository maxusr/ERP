<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Rappel
 *
 * @ORM\Table(name="rappel")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\RappelRepository")
 */
class Rappel extends \CoreBundle\Utils\JsonObject
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=64)
     */
    private $type;
    const RAPPEL_RDV = "rdv";
    const RAPPEL_STANDARD = "rappel";

    /**
     * @var string
     *
     * @ORM\Column(name="dateRappel", type="string", length=64)
     */
    private $dateRappel;

    /**
     * @var string
     *
     * @ORM\Column(name="heureRappel", type="string", length=64)
     */
    private $heureRappel;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="avant", type="string", length=64, nullable=true)
     */
    private $avant;
	const RAPPELS = array('aucun' => "Au moment",'1h' => "1h Avant",'2h' => "2h Avant",'1j' => "1 Jour Avant");
	const AVANT = array("Au moment" => 'aucun' ,"1 Heure Avant" => '1h' ,"1 Jour Avant" => '1j', "1 Semaine Avant" => '1s');

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="rappels")
     */
    private $sender;

    /**
     * @var bool
     *
     * @ORM\Column(name="display", type="boolean")
     */
    private $display;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * Constructor
     *
     */
    public function __construct() {
        $this->type = self::RAPPEL_STANDARD;
        $this->date = new \DateTime;
        $this->display = true;
    }



    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return Rappel
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set dateRappel
     *
     * @param string $dateRappel
     *
     * @return Rappel
     */
    public function setDateRappel($dateRappel)
    {
        $this->dateRappel = $dateRappel;

        return $this;
    }

    /**
     * Get dateRappel
     *
     * @return string
     */
    public function getDateRappel()
    {
        return $this->dateRappel;
    }

    /**
     * Set heureRappel
     *
     * @param string $heureRappel
     *
     * @return Rappel
     */
    public function setHeureRappel($heureRappel)
    {
        $this->heureRappel = $heureRappel;

        return $this;
    }

    /**
     * Get heureRappel
     *
     * @return string
     */
    public function getHeureRappel()
    {
        return $this->heureRappel;
    }

    /**
     * Set content
     *
     * @param string $content
     *
     * @return Rappel
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set avant
     *
     * @param string $avant
     *
     * @return Rappel
     */
    public function setAvant($avant)
    {
        $this->avant = $avant;

        return $this;
    }

    /**
     * Get avant
     *
     * @return string
     */
    public function getAvant()
    {
        return $this->avant;
    }

    /**
     * Set display
     *
     * @param boolean $display
     *
     * @return Rappel
     */
    public function setDisplay($display)
    {
        $this->display = $display;

        return $this;
    }

    /**
     * Get display
     *
     * @return boolean
     */
    public function getDisplay()
    {
        return $this->display;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Rappel
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set sender
     *
     * @param \CoreBundle\Entity\User $sender
     *
     * @return Rappel
     */
    public function setSender(\CoreBundle\Entity\User $sender = null)
    {
        $this->sender = $sender;

        return $this;
    }

    /**
     * Get sender
     *
     * @return \CoreBundle\Entity\User
     */
    public function getSender()
    {
        return $this->sender;
    }

	public function dateRappel() {
		$date = $this->dateRappel." ".$this->heureRappel;
		$date = new \DateTime($date);

		return $date;
	}

	public function heure() {
		$date = $this->dateRappel();

		return $date->format('H\hi');
	}

	public function jour() {
		$date = $this->dateRappel();

		return \CoreBundle\Utils\Utils::dateFormat($date);
	}

	public function isShowable() {
		if($this->display == false)
			return false;


		$now = new \DateTime();
		$interval = $this->dateRappel()->diff($now);
		
		if($interval->invert == 0 && $interval->h < 24)
			return true;

		switch ($this->avant) {
			case 'aucun':
					if($interval->h == 0 && $interval->days == 0)
						return true;
				break;
			case '1h':
					if($interval->h <= 1 && $interval->days == 0)
						return true;
				break;
			case '2h':
					if($interval->h <= 2 && $interval->days == 0)
						return true;
				break;
			case '1j':
					if($interval->days <= 1)
						return true;
				break;
			
			default:
				return true;
				break;
		}

		return false;
	}

	public function isPassed() {
		$date = $this->dateRappel();
		$now = new \DateTime();

		$interval = $date->diff($now);
		//die(var_dump($interval));
		return $interval->invert == 1 ? false : true;
	}

    public function getObjectVars() {
        return get_object_vars($this);
    }
}
