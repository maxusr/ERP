<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Personne
 *
 * @ORM\Table(name="personne")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PersonneRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Personne extends \CoreBundle\Utils\JsonObject implements \CoreBundle\Utils\Conditionnable
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
     * @ORM\Column(name="name", type="string", length=64)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="surname", type="string", length=64)
     */
    private $surname;

    /**
     * @var string
     *
     * @ORM\Column(name="longname", type="string", length=132)
     */
    private $longname;

    /**
     * @var string
     *
     * @ORM\Column(name="civility", type="string", length=32)
     */
    private $civility;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, nullable=true)
     * @Assert\Email(message="E-mail non valide")
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="telephone", type="string", length=64, nullable=true)
     */
    private $telephone;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiant", type="string", length=128)
     */
    private $identifiant;

    /**
     * @var string
     *
     * @ORM\Column(name="identifiantType", type="string", length=64)
     */
    private $identifiantType;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateNaissance", type="datetime")
     */
    private $dateNaissance;

    /**
     * @var string
     *
     * @ORM\Column(name="lieuNaissance", type="string", length=128, nullable=true)
     */
    private $lieuNaissance;

    /**
     * @var Region
     *
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="personnes")
     */
    private $regionOrigine;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Domaine", mappedBy="personnes")
     */
    private $domaines;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="text", nullable=true)
     */
    private $competence;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Dossier
     *
     * @ORM\OneToOne(targetEntity="Dossier", mappedBy="personne")
     */
    private $dossier;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->domaines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->dateNaissance = new \DateTime();
    }


    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        $this->longname = $this->civility.' '.$this->name.' '.$this->surname;
    }

    public function identifiantReadable() {
        $keys = array_flip(User::IDENTIFIANT_TYPES);

        return $keys[$this->identifiantType];
    }

    public function dateNaissanceReadable() {
        $date = $this->getDateNaissance();

        return \CoreBundle\Utils\Utils::dateFormat($date);
    }

    public function age() {
        $date = $this->getDateNaissance();
        $now = new \DateTime();
        return $date->diff($now)->y;
    }

    public function getObjectVars() {
        return get_object_vars($this);
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
     * Set name
     *
     * @param string $name
     *
     * @return Personne
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     *
     * @return Personne
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set longname
     *
     * @param string $longname
     *
     * @return Personne
     */
    public function setLongname($longname)
    {
        $this->longname = $longname;

        return $this;
    }

    /**
     * Get longname
     *
     * @return string
     */
    public function getLongname()
    {
        return $this->longname;
    }

    /**
     * Set civility
     *
     * @param string $civility
     *
     * @return Personne
     */
    public function setCivility($civility)
    {
        $this->civility = $civility;

        return $this;
    }

    /**
     * Get civility
     *
     * @return string
     */
    public function getCivility()
    {
        return $this->civility;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return Personne
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set telephone
     *
     * @param string $telephone
     *
     * @return Personne
     */
    public function setTelephone($telephone)
    {
        $this->telephone = $telephone;

        return $this;
    }

    /**
     * Get telephone
     *
     * @return string
     */
    public function getTelephone()
    {
        return $this->telephone;
    }

    /**
     * Set identifiant
     *
     * @param string $identifiant
     *
     * @return Personne
     */
    public function setIdentifiant($identifiant)
    {
        $this->identifiant = $identifiant;

        return $this;
    }

    /**
     * Get identifiant
     *
     * @return string
     */
    public function getIdentifiant()
    {
        return $this->identifiant;
    }

    /**
     * Set identifiantType
     *
     * @param string $identifiantType
     *
     * @return Personne
     */
    public function setIdentifiantType($identifiantType)
    {
        $this->identifiantType = $identifiantType;

        return $this;
    }

    /**
     * Get identifiantType
     *
     * @return string
     */
    public function getIdentifiantType()
    {
        return $this->identifiantType;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Personne
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set lieuNaissance
     *
     * @param string $lieuNaissance
     *
     * @return Personne
     */
    public function setLieuNaissance($lieuNaissance)
    {
        $this->lieuNaissance = $lieuNaissance;

        return $this;
    }

    /**
     * Get lieuNaissance
     *
     * @return string
     */
    public function getLieuNaissance()
    {
        return $this->lieuNaissance;
    }

    /**
     * Set competence
     *
     * @param string $competence
     *
     * @return Personne
     */
    public function setCompetence($competence)
    {
        $this->competence = $competence;

        return $this;
    }

    /**
     * Get competence
     *
     * @return string
     */
    public function getCompetence()
    {
        return $this->competence;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Personne
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set regionOrigine
     *
     * @param \CoreBundle\Entity\Region $regionOrigine
     *
     * @return Personne
     */
    public function setRegionOrigine(\CoreBundle\Entity\Region $regionOrigine = null)
    {
        $this->regionOrigine = $regionOrigine;

        return $this;
    }

    /**
     * Get regionOrigine
     *
     * @return \CoreBundle\Entity\Region
     */
    public function getRegionOrigine()
    {
        return $this->regionOrigine;
    }

    /**
     * Add domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     *
     * @return Personne
     */
    public function addDomaine(\CoreBundle\Entity\Domaine $domaine)
    {
        $this->domaines[] = $domaine;

        return $this;
    }

    /**
     * Remove domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     */
    public function removeDomaine(\CoreBundle\Entity\Domaine $domaine)
    {
        $this->domaines->removeElement($domaine);
    }

    /**
     * Get domaines
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDomaines()
    {
        return $this->domaines;
    }

    /**
     * Set dossier
     *
     * @param \CoreBundle\Entity\Dossier $dossier
     *
     * @return Personne
     */
    public function setDossier(\CoreBundle\Entity\Dossier $dossier = null)
    {
        $this->dossier = $dossier;

        return $this;
    }

    /**
     * Get dossier
     *
     * @return \CoreBundle\Entity\Dossier
     */
    public function getDossier()
    {
        return $this->dossier;
    }

    public function getAge() {
        $now = new \DateTime();
        $diff = $this->getDateNaissance()->diff($now);

        return $diff->y;
    }

    public function getSexe() {
        if(strtolower($this->civility) == 'm') {
            return 'm';
        }

        return 'f';
    }

    public function getRegion() {
        return $this->regionOrigine->getName();
    }

    public function getProfile() {
        return $this->getDescription();
    }

    public function conditionOf() {
        return 'personne';
    }
}
