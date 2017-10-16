<?php

namespace CMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="CMBundle\Repository\ProductRepository")
 */
class Product
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="reference", type="string", length=255, nullable=true)
     */
    private $reference;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isConsommable", type="boolean", nullable=true)
     */
    private $isConsommable;

    /**
     * @var boolean
     *
     * @ORM\Column(name="isAvailable", type="boolean", nullable=true)
     */
    private $isAvailable;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="insertedAt", type="datetime")
     */
    private $insertedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var Input
     *
     * @ORM\OneToMany(targetEntity="Input", mappedBy="product")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $inputs;

    /**
     * @var State
     *
     * @ORM\OneToMany(targetEntity="State", mappedBy="product", cascade={"remove", "persist"})
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $states;

    /**
     * @var Output
     *
     * @ORM\OneToMany(targetEntity="Output", mappedBy="product")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $outputs;

    /**
     * @var Category
     *
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="products")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $category;

    /**
     * @var CoreBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $saver;

    public function __construct() {
        $this->insertedAt = new \DateTime;
        $this->isConsommable = false;
        $this->isAvailable = true;
    }


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
     * Set name
     *
     * @param string $name
     *
     * @return Product
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Product
     */
    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    /**
     * Get reference
     *
     * @return string
     */
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * Set insertedAt
     *
     * @param \DateTime $insertedAt
     *
     * @return Product
     */
    public function setInsertedAt($insertedAt)
    {
        $this->insertedAt = $insertedAt;

        return $this;
    }

    /**
     * Get insertedAt
     *
     * @return \DateTime
     */
    public function getInsertedAt()
    {
        return $this->insertedAt;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Product
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
     * Add input
     *
     * @param \CMBundle\Entity\Input $input
     *
     * @return Product
     */
    public function addInput(\CMBundle\Entity\Input $input)
    {
        $this->inputs[] = $input;

        return $this;
    }

    /**
     * Remove input
     *
     * @param \CMBundle\Entity\Input $input
     */
    public function removeInput(\CMBundle\Entity\Input $input)
    {
        $this->inputs->removeElement($input);
    }

    /**
     * Get inputs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getInputs()
    {
        return $this->inputs;
    }

    /**
     * Add output
     *
     * @param \CMBundle\Entity\Output $output
     *
     * @return Product
     */
    public function addOutput(\CMBundle\Entity\Output $output)
    {
        $this->outputs[] = $output;

        return $this;
    }

    /**
     * Remove output
     *
     * @param \CMBundle\Entity\Output $output
     */
    public function removeOutput(\CMBundle\Entity\Output $output)
    {
        $this->outputs->removeElement($output);
    }

    /**
     * Get outputs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getOutputs()
    {
        return $this->outputs;
    }

    /**
     * Set category
     *
     * @param \CMBundle\Entity\Category $category
     *
     * @return Product
     */
    public function setCategory(\CMBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \CMBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set saver
     *
     * @param \CoreBundle\Entity\User $saver
     *
     * @return Product
     */
    public function setSaver(\CoreBundle\Entity\User $saver = null)
    {
        $this->saver = $saver;

        return $this;
    }

    /**
     * Get saver
     *
     * @return \CoreBundle\Entity\User
     */
    public function getSaver()
    {
        return $this->saver;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set isConsommable
     *
     * @param boolean $isConsommable
     *
     * @return Product
     */
    public function setIsConsommable($isConsommable)
    {
        $this->isConsommable = $isConsommable;

        return $this;
    }

    /**
     * Get isConsommable
     *
     * @return boolean
     */
    public function getIsConsommable()
    {
        return $this->isConsommable;
    }

    /**
     * Add state
     *
     * @param \CMBundle\Entity\State $state
     *
     * @return Product
     */
    public function addState(\CMBundle\Entity\State $state)
    {
        $this->states[] = $state;

        return $this;
    }

    /**
     * Remove state
     *
     * @param \CMBundle\Entity\State $state
     */
    public function removeState(\CMBundle\Entity\State $state)
    {
        $this->states->removeElement($state);
    }

    /**
     * Get states
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStates()
    {
        return $this->states;
    }

    /**
     * Set isAvailable
     *
     * @param boolean $isAvailable
     *
     * @return Product
     */
    public function setIsAvailable($isAvailable)
    {
        $this->isAvailable = $isAvailable;

        return $this;
    }

    /**
     * Get isAvailable
     *
     * @return boolean
     */
    public function getIsAvailable()
    {
        return $this->isAvailable;
    }
}
