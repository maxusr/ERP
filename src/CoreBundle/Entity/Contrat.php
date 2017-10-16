<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Contrat
 *
 * @ORM\Table(name="contrat")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ContratRepository")
 */
class Contrat extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="type", type="string", length=32)
     */
    private $type;
    const TYPES = array("CDI" => "cdi", "CDD" => "cdd", "Essai" => "essai", "Stage" => "stage", "Consultant" => "consultant");

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
     * @ORM\OneToOne(targetEntity="User", mappedBy="contrat")
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
     * @return Contrat
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
     * Set employe
     *
     * @param \CoreBundle\Entity\User $employe
     *
     * @return Contrat
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

    /**
     * Set debut
     *
     * @param \DateTime $debut
     *
     * @return Contrat
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
     * @return Contrat
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
        $date = new \DateTime();

        return $this->debut != null ? \CoreBundle\Utils\Utils::dateFormat($this->debut) : null;
    }

    public function finReadable() {
        $date = new \DateTime();

        return $this->fin != null ? \CoreBundle\Utils\Utils::dateFormat($this->fin) : null;
    }
}
