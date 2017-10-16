<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Competence
 *
 * @ORM\Table(name="competence")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\CompetenceRepository")
 */
class Competence
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

    const NAMES = ["Nom" => "name", "Age" => "age", "Sexe (Valeurs: m ou f)" => "sexe", "Région d'origine" => "region"];
    const COMPARATORS = ["Egal" => "==", "Supérieur" => ">", "Supérieur ou égal" => ">=", "Inférieur" => "<", "Inférieur ou égal" => "<=", "Différent" => "#", "Contient" => "%%", "Contient pas" => "^%"];

    /**
     * @var string
     *
     * @ORM\Column(name="comparator", type="string", length=255)
     */
    private $comparator;

    /**
     * @var string
     *
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Poste", inversedBy="conditions")
     */
    private $poste;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Service", inversedBy="conditions")
     */
    private $service;

    public function isOk(\CoreBundle\Utils\Conditionnable $c) {
        $method = 'get'.ucfirst($this->getName());
        $value = $c->$method();

        switch ($this->comparator) {
            case '==':
                return strtolower($this->value) == strtolower($value);

            case '<=':
                return $this->value <= $value;

            case '>=':
                return $this->value >= $value;

            case '>':
                return $this->value > $value;

            case '<':
                return $this->value < $value;

            case '#':
                return $this->value != $value;

            case '%%':
                return strripos($this->value, $value) > 0 ? true : false;

            case '^%':
                return strripos($this->value, $value) > 0 ? false : true;
        }

        return true;
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
     * @return Competence
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
     * Set comparator
     *
     * @param string $comparator
     *
     * @return Competence
     */
    public function setComparator($comparator)
    {
        $this->comparator = $comparator;

        return $this;
    }

    /**
     * Get comparator
     *
     * @return string
     */
    public function getComparator()
    {
        return $this->comparator;
    }

    /**
     * Set value
     *
     * @param string $value
     *
     * @return Competence
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * Set poste
     *
     * @param \CoreBundle\Entity\Poste $poste
     *
     * @return Competence
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

    /**
     * Set service
     *
     * @param \CoreBundle\Entity\Service $service
     *
     * @return Competence
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
