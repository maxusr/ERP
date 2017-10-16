<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product_market")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\ProductRepository")
 * @ORM\HasLifecycleCallbacks()
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
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=24, nullable=true)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean")
     */
    private $available;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductVariant", mappedBy="product")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $variants;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToOne(targetEntity="ProductVariant", cascade={"persist", "remove"})
     */
    private $firstVariant;


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
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set observation
     *
     * @param string $observation
     *
     * @return Product
     */
    public function setObservation($observation)
    {
        $this->observation = $observation;

        return $this;
    }

    /**
     * Get observation
     *
     * @return string
     */
    public function getObservation()
    {
        return $this->observation;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set available
     *
     * @param boolean $available
     *
     * @return Product
     */
    public function setAvailable($available)
    {
        $this->available = $available;

        return $this;
    }

    /**
     * Get available
     *
     * @return bool
     */
    public function getAvailable()
    {
        return $this->available;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->variants = new \Doctrine\Common\Collections\ArrayCollection();
        $this->available = true;
    }

    /**
     * Add variant
     *
     * @param \MarketBundle\Entity\ProductVariant $variant
     *
     * @return Product
     */
    public function addVariant(\MarketBundle\Entity\ProductVariant $variant)
    {
        $this->variants[] = $variant;

        return $this;
    }

    /**
     * Remove variant
     *
     * @param \MarketBundle\Entity\ProductVariant $variant
     */
    public function removeVariant(\MarketBundle\Entity\ProductVariant $variant)
    {
        $this->variants->removeElement($variant);
    }

    /**
     * Get variants
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getVariants()
    {
        return $this->variants;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        $variant = new ProductVariant();
        $variant->setAvailable($this->available);
        $variant->setName($this->name);
        $variant->setPrice($this->price);
        $variant->setProduct($this);
        $variant->setQuantity($this->quantity);

        $this->firstVariant = $variant;
    }

    /**
     * Set firstVariant
     *
     * @param \MarketBundle\Entity\ProductVariant $firstVariant
     *
     * @return Product
     */
    public function setFirstVariant(\MarketBundle\Entity\ProductVariant $firstVariant = null)
    {
        $this->firstVariant = $firstVariant;

        return $this;
    }

    /**
     * Get firstVariant
     *
     * @return \MarketBundle\Entity\ProductVariant
     */
    public function getFirstVariant()
    {
        return $this->firstVariant;
    }
}
