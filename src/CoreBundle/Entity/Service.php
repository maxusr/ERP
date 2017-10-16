<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Service
 *
 * @ORM\Table(name="service")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\ServiceRepository")
 */
class Service
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
     * @ORM\Column(name="name", type="string", length=255)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="competence", type="text")
     */
    private $competence;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="text")
     */
    private $profil;

    /**
     * @var string
     *
     * @ORM\Column(name="discipline", type="text")
     */
    private $discipline;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Competence", mappedBy="service")
     */
    private $conditions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Domaine")
     */
    private $domaines;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Poste", mappedBy="service")
     */
    private $postes;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->conditions = new \Doctrine\Common\Collections\ArrayCollection();
        $this->postes = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Service
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
     * Set competence
     *
     * @param string $competence
     *
     * @return Service
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
     * Set profil
     *
     * @param string $profil
     *
     * @return Service
     */
    public function setProfil($profil)
    {
        $this->profil = $profil;

        return $this;
    }

    /**
     * Get profil
     *
     * @return string
     */
    public function getProfil()
    {
        return $this->profil;
    }

    /**
     * Set discipline
     *
     * @param string $discipline
     *
     * @return Service
     */
    public function setDiscipline($discipline)
    {
        $this->discipline = $discipline;

        return $this;
    }

    /**
     * Get discipline
     *
     * @return string
     */
    public function getDiscipline()
    {
        return $this->discipline;
    }

    /**
     * Add condition
     *
     * @param \CoreBundle\Entity\Competence $condition
     *
     * @return Service
     */
    public function addCondition(\CoreBundle\Entity\Competence $condition)
    {
        $this->conditions[] = $condition;

        return $this;
    }

    /**
     * Remove condition
     *
     * @param \CoreBundle\Entity\Competence $condition
     */
    public function removeCondition(\CoreBundle\Entity\Competence $condition)
    {
        $this->conditions->removeElement($condition);
    }

    /**
     * Get conditions
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getConditions()
    {
        return $this->conditions;
    }

    /**
     * Add poste
     *
     * @param \CoreBundle\Entity\Poste $poste
     *
     * @return Service
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
     * Add domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     *
     * @return Service
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
}
