<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductVariant
 *
 * @ORM\Table(name="product_variant_market")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\ProductVariantRepository")
 */
class ProductVariant
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
     * @ORM\Column(name="quantity", type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="string", length=24)
     */
    private $price;

    /**
     * @var bool
     *
     * @ORM\Column(name="available", type="boolean", nullable=true)
     */
    private $available;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CommandeItem", mappedBy="product")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $items;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="variants")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $product;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductAttributeValue", mappedBy="product")
     * @ORM\JoinColumn(onDelete="CASCADE")
     */
    private $attributeValues;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="ProductQuantity", mappedBy="product")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $quantities;


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
     * @return ProductVariant
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
     * @return ProductVariant
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
     * Set price
     *
     * @param string $price
     *
     * @return ProductVariant
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
     * @return ProductVariant
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
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->attributeValues = new \Doctrine\Common\Collections\ArrayCollection();
        $this->available = true;
    }

    /**
     * Add commande
     *
     * @param \MarketBundle\Entity\Commande $commande
     *
     * @return ProductVariant
     */
    public function addCommande(\MarketBundle\Entity\Commande $commande)
    {
        $this->commandes[] = $commande;

        return $this;
    }

    /**
     * Remove commande
     *
     * @param \MarketBundle\Entity\Commande $commande
     */
    public function removeCommande(\MarketBundle\Entity\Commande $commande)
    {
        $this->commandes->removeElement($commande);
    }

    /**
     * Get commandes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCommandes()
    {
        return $this->commandes;
    }

    /**
     * Set product
     *
     * @param \MarketBundle\Entity\Product $product
     *
     * @return ProductVariant
     */
    public function setProduct(\MarketBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MarketBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Add attributeValue
     *
     * @param \MarketBundle\Entity\ProductAttributeValue $attributeValue
     *
     * @return ProductVariant
     */
    public function addAttributeValue(\MarketBundle\Entity\ProductAttributeValue $attributeValue)
    {
        $this->attributeValues[] = $attributeValue;

        return $this;
    }

    /**
     * Remove attributeValue
     *
     * @param \MarketBundle\Entity\ProductAttributeValue $attributeValue
     */
    public function removeAttributeValue(\MarketBundle\Entity\ProductAttributeValue $attributeValue)
    {
        $this->attributeValues->removeElement($attributeValue);
    }

    /**
     * Get attributeValues
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getAttributeValues()
    {
        return $this->attributeValues;
    }

    /**
     * Add item
     *
     * @param \MarketBundle\Entity\CommandeItem $item
     *
     * @return ProductVariant
     */
    public function addItem(\MarketBundle\Entity\CommandeItem $item)
    {
        $this->items[] = $item;

        return $this;
    }

    /**
     * Remove item
     *
     * @param \MarketBundle\Entity\CommandeItem $item
     */
    public function removeItem(\MarketBundle\Entity\CommandeItem $item)
    {
        $this->items->removeElement($item);
    }

    /**
     * Get items
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Add quantity
     *
     * @param \MarketBundle\Entity\ProductQuantity $quantity
     *
     * @return ProductVariant
     */
    public function addQuantity(\MarketBundle\Entity\ProductQuantity $quantity)
    {
        $this->quantities[] = $quantity;

        return $this;
    }

    /**
     * Remove quantity
     *
     * @param \MarketBundle\Entity\ProductQuantity $quantity
     */
    public function removeQuantity(\MarketBundle\Entity\ProductQuantity $quantity)
    {
        $this->quantities->removeElement($quantity);
    }

    /**
     * Get quantities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getQuantities()
    {
        return $this->quantities;
    }
}
