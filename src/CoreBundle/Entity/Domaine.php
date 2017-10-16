<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Domaine
 *
 * @ORM\Table(name="domaine")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\DomaineRepository")
 */
class Domaine extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="text")
     */
    private $competence;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Poste")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $postes;

    /**
     * @var Dossier
     *
     * @ORM\OneToMany(targetEntity="Dossier", mappedBy="domaine", cascade={"merge"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $dossiers;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="User", mappedBy="domaine")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $employes;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Personne")
     */
    private $personnes;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->dossiers = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Domaine
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
     * Set description
     *
     * @param string $description
     *
     * @return Domaine
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
     * Set competence
     *
     * @param string $competence
     *
     * @return Domaine
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
     * Add dossier
     *
     * @param \CoreBundle\Entity\Dossier $dossier
     *
     * @return Domaine
     */
    public function addDossier(\CoreBundle\Entity\Dossier $dossier)
    {
        $this->dossiers[] = $dossier;

        return $this;
    }

    /**
     * Remove dossier
     *
     * @param \CoreBundle\Entity\Dossier $dossier
     */
    public function removeDossier(\CoreBundle\Entity\Dossier $dossier)
    {
        $this->dossiers->removeElement($dossier);
    }

    /**
     * Get dossiers
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDossiers()
    {
        return $this->dossiers;
    }

    /**
     * Add employe
     *
     * @param \CoreBundle\Entity\User $employe
     *
     * @return Domaine
     */
    public function addEmploye(\CoreBundle\Entity\User $employe)
    {
        $this->employes[] = $employe;

        return $this;
    }

    /**
     * Remove employe
     *
     * @param \CoreBundle\Entity\User $employe
     */
    public function removeEmploye(\CoreBundle\Entity\User $employe)
    {
        $this->employes->removeElement($employe);
    }

    /**
     * Get employes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEmployes()
    {
        return $this->employes;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    /**
     * Add poste
     *
     * @param \CoreBundle\Entity\Poste $poste
     *
     * @return Domaine
     */
    public function addPoste(\CoreBundle\Entity\Poste $poste)
    {
        $this->postes[] = $poste;

        return $this;
    }

    /**
     * Remove poste
     *
     * @param \CoreBundle\Entity\Poste $poste
     */
    public function removePoste(\CoreBundle\Entity\Poste $poste)
    {
        $this->postes->removeElement($poste);
    }

    /**
     * Get postes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPostes()
    {
        return $this->postes;
    }

    /**
     * Add personne
     *
     * @param \CoreBundle\Entity\Personne $personne
     *
     * @return Domaine
     */
    public function addPersonne(\CoreBundle\Entity\Personne $personne)
    {
        $this->personnes[] = $personne;

        return $this;
    }

    /**
     * Remove personne
     *
     * @param \CoreBundle\Entity\Personne $personne
     */
    public function removePersonne(\CoreBundle\Entity\Personne $personne)
    {
        $this->personnes->removeElement($personne);
    }

    /**
     * Get personnes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPersonnes()
    {
        return $this->personnes;
    }
}
