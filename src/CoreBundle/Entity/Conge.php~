<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Conge
 *
 * @ORM\Table(name="conge")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CongeRepository")
 */
class Conge extends \CoreBundle\Utils\JsonObject
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
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="conges")
     * @ORM\JoinColumn(onDelete="SET NULL")
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
     * Set employe
     *
     * @param \CoreBundle\Entity\User $employe
     *
     * @return Conge
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

    public function duree() {
        if($this->debut != null && $this->fin != null) {
            $debut = $this->debut;
            $fin = $this->fin;

            return $debut->diff($fin)->days;
        }else{
            return null;
        }
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

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Conge
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
     * @return Conge
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
