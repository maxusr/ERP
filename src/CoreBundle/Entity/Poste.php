<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Poste
 *
 * @ORM\Table(name="poste")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\PosteRepository")
 */
class Poste extends \CoreBundle\Utils\JsonObject
{
    use \CoreBundle\Utils\Permission;
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
     * @ORM\Column(name="attribution", type="string", length=255)
     */
    private $attribution;

    /**
     * @var int
     *
     * @ORM\Column(name="number", type="integer")
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="categorie", type="integer")
     * @Assert\Range(
     *      min = 1,
     *      max = 12,
     *      minMessage = "La catégorie doit être au moins {{ limit }}",
     *      maxMessage = "La catégorie doit être au plus {{ limit }}"
     * )
     */
    private $categorie;

    /**
     * @var string
     *
     * @ORM\Column(name="profil", type="text")
     */
    private $profil;

    /**
     * @var array
     *
     * @ORM\Column(name="permissions", type="array")
     */
    private $permissions;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Domaine")
     */
    private $domaines;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Echelon", mappedBy="poste", cascade={"persist", "remove"})
     */
    private $echelons;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Competence", mappedBy="poste")
     */
    private $conditions;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="postes")
     */
    private $service;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->domaines = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    public function getCompetence() {
        return $this->profil;
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
     * @return Poste
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
     * Set number
     *
     * @param integer $number
     *
     * @return Poste
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Add domaine
     *
     * @param \CoreBundle\Entity\Domaine $domaine
     *
     * @return Poste
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
     * Add echelon
     *
     * @param \CoreBundle\Entity\Echelon $echelon
     *
     * @return Poste
     */
    public function addEchelon(\CoreBundle\Entity\Echelon $echelon)
    {
        $this->echelons[] = $echelon;

        return $this;
    }

    /**
     * Remove echelon
     *
     * @param \CoreBundle\Entity\Echelon $echelon
     */
    public function removeEchelon(\CoreBundle\Entity\Echelon $echelon)
    {
        $this->echelons->removeElement($echelon);
    }

    /**
     * Get echelons
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getEchelons()
    {
        return $this->echelons;
    }

    /**
     * Set permissions
     *
     * @param array $permissions
     *
     * @return Poste
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }

    /**
     * Get permissions
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    public function getObjectVars() {
        return get_object_vars($this);
    }

    /**
     * Set categorie
     *
     * @param integer $categorie
     *
     * @return Poste
     */
    public function setCategorie($categorie)
    {
        $this->categorie = $categorie;

        return $this;
    }

    /**
     * Get categorie
     *
     * @return integer
     */
    public function getCategorie()
    {
        return $this->categorie;
    }

    /**
     * Set attribution
     *
     * @param string $attribution
     *
     * @return Poste
     */
    public function setAttribution($attribution)
    {
        $this->attribution = $attribution;

        return $this;
    }

    /**
     * Get attribution
     *
     * @return string
     */
    public function getAttribution()
    {
        return $this->attribution;
    }

    /**
     * Set profil
     *
     * @param string $profil
     *
     * @return Poste
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
     * Add condition
     *
     * @param \CoreBundle\Entity\Competence $condition
     *
     * @return Poste
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
     * Set service
     *
     * @param \CoreBundle\Entity\Service $service
     *
     * @return Poste
     */
    public function setService(\CoreBundle\Entity\Service $service = null)
    {
        $this->service = $service;

        return $this;
    }

    /**
     * Get service
     *
     * @return \CoreBundle\Entity\Service
     */
    public function getService()
    {
        return $this->service;
    }
}
