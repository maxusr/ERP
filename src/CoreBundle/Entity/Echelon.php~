<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Echelon
 *
 * @ORM\Table(name="echelon")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\EchelonRepository")
 */
class Echelon extends \CoreBundle\Utils\JsonObject
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
     * @var int
     *
     * @ORM\Column(name="niveau", type="string")
     * @Assert\Choice(choices = {"A", "B", "C", "D", "E", "F"}, message = "Choisissez un niveau valide.")
     */
    private $niveau;

    const NIVEAUX = array("A" => "A", "B" => "B", "C" => "C", "D" => "D", "E" => "E", "F" => "F");

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetime")
     */
    private $date;

    /**
     * @var int
     *
     * @ORM\Column(name="duree_conge", type="integer")
     */
    private $dureeConge;

    /**
     * @var string
     *
     * @ORM\Column(name="designation", type="string", length=255, nullable=true)
     */
    private $designation;

    /**
     * @var UserEchelon
     *
     * @ORM\OneToMany(targetEntity="UserEchelon", mappedBy="echelon", cascade={"persist", "remove"})
     */
    private $userEchelons;

    /**
     * @var Poste
     *
     * @ORM\ManyToOne(targetEntity="Poste", inversedBy="echelons")
     */
    private $poste;

    /**
     * @var Salaire
     *
     * @ORM\OneToOne(targetEntity="Salaire", inversedBy="echelon")
     */
    private $salaire;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set niveau
     *
     * @param integer $niveau
     *
     * @return Echelon
     */
    public function setNiveau($niveau)
    {
        $this->niveau = $niveau;

        return $this;
    }

    /**
     * Get niveau
     *
     * @return int
     */
    public function getNiveau()
    {
        return $this->niveau;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Echelon
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
     * Set designation
     *
     * @param string $designation
     *
     * @return Echelon
     */
    public function setDesignation($designation)
    {
        $this->designation = $designation;

        return $this;
    }

    /**
     * Get designation
     *
     * @return string
     */
    public function getDesignation()
    {
        return $this->designation;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->date = new \DateTime();
    }

    /**
     * Set poste
     *
     * @param \CoreBundle\Entity\Poste $poste
     *
     * @return Echelon
     */
    public function setPoste(\CoreBundle\Entity\Poste $poste = null)
    {
        $this->poste = $poste;

        return $this;
    }

    /**
     * Get poste
     *
     * @return \CoreBundle\Entity\Poste
     */
    public function getPoste()
    {
        return $this->poste;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    /**
     * Add userEchelon
     *
     * @param \CoreBundle\Entity\UserEchelon $userEchelon
     *
     * @return Echelon
     */
    public function addUserEchelon(\CoreBundle\Entity\UserEchelon $userEchelon)
    {
        $this->userEchelons[] = $userEchelon;

        return $this;
    }

    /**
     * Remove userEchelon
     *
     * @param \CoreBundle\Entity\UserEchelon $userEchelon
     */
    public function removeUserEchelon(\CoreBundle\Entity\UserEchelon $userEchelon)
    {
        $this->userEchelons->removeElement($userEchelon);
    }

    /**
     * Get userEchelons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getUserEchelons()
    {
        return $this->userEchelons;
    }

    /**
     * Set dureeConge
     *
     * @param integer $dureeConge
     *
     * @return Echelon
     */
    public function setDureeConge($dureeConge)
    {
        $this->dureeConge = $dureeConge;

        return $this;
    }

    /**
     * Get dureeConge
     *
     * @return integer
     */
    public function getDureeConge()
    {
        return $this->dureeConge;
    }

    /**
     * Set salaire
     *
     * @param \CoreBundle\Entity\Salaire $salaire
     *
     * @return Echelon
     */
    public function setSalaire(\CoreBundle\Entity\Salaire $salaire = null)
    {
        $this->salaire = $salaire;

        return $this;
    }

    /**
     * Get salaire
     *
     * @return \CoreBundle\Entity\Salaire
     */
    public function getSalaire()
    {
        return $this->salaire;
    }
}
