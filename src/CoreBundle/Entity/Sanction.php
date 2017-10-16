<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sanction
 *
 * @ORM\Table(name="sanction")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\SanctionRepository")
 */
class Sanction extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="type", type="string", length=128)
     */
    private $type;
    
    const TYPES = array("Blames" => "blm", "Avertissement" => "avert", "Mise à pied" => "map", "Licenciement" => "licencie");

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="debut", type="date")
     */
    private $debut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="fin", type="date", nullable=true)
     */
    private $fin;


    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var User
     * @ORM\ManyToOne(targetEntity="User", inversedBy="sanctions")
     */
    private $employe;



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
     * @return Sanction
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
     * Set content
     *
     * @param string $content
     *
     * @return Sanction
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
     * Set title
     *
     * @param string $title
     *
     * @return Sanction
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set employe
     *
     * @param \CoreBundle\Entity\User $employe
     *
     * @return Sanction
     */
    public function setEmploye(\CoreBundle\Entity\User $employe = null)
    {
        $this->employe = $employe;

        return $this;
    }

    /**
     * Get employe
     *
     * @return \CoreBundle\Entity\User
     */
    public function getEmploye()
    {
        return $this->employe;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    public function debutReadable() {
        if(is_string($this->debut)) {
            $date = new \DateTime($this->debut);
        }else{
            $date = $this->debut;
        }

        return $date != null ? \CoreBundle\Utils\Utils::dateFormat($date) : null;
    }

    public function finReadable() {
        if(is_string($this->fin)) {
            $date = new \DateTime($this->fin);
        }else{
            $date = $this->fin;
        }

        return $date != null ? \CoreBundle\Utils\Utils::dateFormat($date) : null;
    }

    public function typeReadable() {
        $types = array_flip(self::TYPES);

        return $types[$this->type];
    }

    public function duree() {
        if(is_string($this->debut)) {
            $debut = new \DateTime($this->debut);
        }else{
            $debut = $this->debut;
        }

        if(is_string($this->fin)) {
            $fin = new \DateTime($this->fin);
        }else{
            $fin = $this->fin;
        }

        return $debut->diff($fin)->days;
    }

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Sanction
     */
    public function setDebut($debut)
    {
        $this->debut = $debut;

        return $this;
    }

    /**
     * Get debut
     *
     * @return \DateTime
     */
    public function getDebut()
    {
        return $this->debut;
    }

    /**
     * Set fin
     *
     * @param \DateTime $fin
     *
     * @return Sanction
     */
    public function setFin($fin)
    {
        $this->fin = $fin;

        return $this;
    }

    /**
     * Get fin
     *
     * @return \DateTime
     */
    public function getFin()
    {
        return $this->fin;
    }
}
