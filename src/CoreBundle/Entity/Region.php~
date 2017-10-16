<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Region
 *
 * @ORM\Table(name="region")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\RegionRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Region extends \CoreBundle\Utils\JsonObject
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
     * @ORM\Column(name="code", type="string", length=6, unique=true)
     */
    private $code;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=128)
     */
    private $name;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="Personne", mappedBy="regionOrigine")
     */
    private $personnes;

    /**
     * @var ArrayCollection
     * @ORM\OneToMany(targetEntity="User", mappedBy="regionOrigine")
     */
    private $employes;


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
     * Set code
     *
     * @param string $code
     *
     * @return Region
     */
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get code
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Region
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

    public function getObjectVars() {
        return get_object_vars($this);
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->personnes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->employes = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add personne
     *
     * @param \CoreBundle\Entity\Personne $personne
     *
     * @return Region
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

    /**
     * Add employe
     *
     * @param \CoreBundle\Entity\User $employe
     *
     * @return Region
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

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function prePersist()
    {
        if(strpos($this->name, '-') && strpos($this->name, '-') >= 0) {
            $name = explode('-', $this->name);
        } else if(strpos($this->name, ' ') && strpos($this->name, ' ') >= 0) {
            $name = explode(' ', $this->name);
        }else{
            $name = array(str_replace(' ','-',$this->name));
        }
        $this->code = substr($name[0], 0, 3);
        $this->code = $this->code.'-'.strlen($this->name);
        if(count($name) > 1){
            $this->code = $this->code.'-'.substr($name[1], 0, 3);
        }
        if(count($name) > 2){
            $this->code = $this->code.'-'.substr($name[2], 0, 3);
        }
    }
}
