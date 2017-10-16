<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Commande
 *
 * @ORM\Table(name="commande")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\CommandeRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Commande
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
     * @ORM\Column(name="reference", type="string", length=128, unique=true)
     */
    private $reference;

    /**
     * @var string
     *
     * @ORM\Column(name="denomination", type="string", length=255, unique=true)
     */
    private $denomination;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=24)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="billingMode", type="string", length=255, nullable=true)
     */
    private $billingMode;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingMode", type="string", length=255, nullable=true)
     */
    private $shippingMode;

    /**
     * @var string
     *
     * @ORM\Column(name="shippingCost", type="string", length=255, nullable=true)
     */
    private $shippingCost;

    /**
     * @var int
     *
     * @ORM\Column(name="number_product", type="integer")
     */
    private $numberProduct;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="observation", type="text", nullable=true)
     */
    private $observation;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="CommandeItem", mappedBy="commande", cascade={"persist"})
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $items;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(targetEntity="Client", inversedBy="commandes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $client;

    /**
     * @var Sale
     *
     * @ORM\ManyToOne(targetEntity="Sale", inversedBy="commandes")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $sale;


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
     * Set total
     *
     * @param string $total
     *
     * @return Commande
     */
    public function setTotal($total)
    {
        $this->total = $total;

        return $this;
    }

    /**
     * Get total
     *
     * @return string
     */
    public function getTotal()
    {
        return $this->total;
    }

    /**
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Commande
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
     * Set observation
     *
     * @param string $observation
     *
     * @return Commande
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
     * Constructor
     */
    public function __construct()
    {
        $this->products = new \Doctrine\Common\Collections\ArrayCollection();
        $this->date = new \DateTime;
        $this->shippingCost = 0;
    }

    /**
     * Add product
     *
     * @param \MarketBundle\Entity\ProductVariant $product
     *
     * @return Commande
     */
    public function addProduct(\MarketBundle\Entity\ProductVariant $product)
    {
        $this->products[] = $product;

        return $this;
    }

    /**
     * Remove product
     *
     * @param \MarketBundle\Entity\ProductVariant $product
     */
    public function removeProduct(\MarketBundle\Entity\ProductVariant $product)
    {
        $this->products->removeElement($product);
    }

    /**
     * Get products
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * Set client
     *
     * @param \MarketBundle\Entity\Client $client
     *
     * @return Commande
     */
    public function setClient(\MarketBundle\Entity\Client $client = null)
    {
        $this->client = $client;

        return $this;
    }

    /**
     * Get client
     *
     * @return \MarketBundle\Entity\Client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set sale
     *
     * @param \MarketBundle\Entity\Sale $sale
     *
     * @return Commande
     */
    public function setSale(\MarketBundle\Entity\Sale $sale = null)
    {
        $this->sale = $sale;

        return $this;
    }

    /**
     * Get sale
     *
     * @return \MarketBundle\Entity\Sale
     */
    public function getSale()
    {
        return $this->sale;
    }

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist() {
        $this->total = 0;
        $this->numberProduct = 0;
        foreach ($this->items as $key => $item) {
            $this->total += ($item->getProduct()->getPrice() * $item->getQuantity());
            $this->numberProduct += $item->getQuantity();
        }
        $this->total += $this->shippingCost;

        if(!empty($this->reference) && $this->client != null){
            $this->denomination = $this->reference.' - '.$this->client->getName();
        }
    }

    /**
     * @ORM\PreRemove
     */
    public function preRemove() {
        if($this->sale) {
            $this->sale->setTotal($this->sale->getTotal() - $this->getTotal());
            $this->sale->estimateTotalTTC();
        }
    }

    /**
     * Set numberProduct
     *
     * @param integer $numberProduct
     *
     * @return Commande
     */
    public function setNumberProduct($numberProduct)
    {
        $this->numberProduct = $numberProduct;

        return $this;
    }

    /**
     * Get numberProduct
     *
     * @return integer
     */
    public function getNumberProduct()
    {
        return $this->numberProduct;
    }

    /**
     * Add item
     *
     * @param \MarketBundle\Entity\CommandeItem $item
     *
     * @return Commande
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
     * Set reference
     *
     * @param string $reference
     *
     * @return Commande
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
     * Set denomination
     *
     * @param string $denomination
     *
     * @return Commande
     */
    public function setDenomination($denomination)
    {
        $this->denomination = $denomination;

        return $this;
    }

    /**
     * Get denomination
     *
     * @return string
     */
    public function getDenomination()
    {
        return $this->denomination;
    }

    /**
     * Set billingMode
     *
     * @param string $billingMode
     *
     * @return Commande
     */
    public function setBillingMode($billingMode)
    {
        $this->billingMode = $billingMode;

        return $this;
    }

    /**
     * Get billingMode
     *
     * @return string
     */
    public function getBillingMode()
    {
        return $this->billingMode;
    }

    /**
     * Set shippingMode
     *
     * @param string $shippingMode
     *
     * @return Commande
     */
    public function setShippingMode($shippingMode)
    {
        $this->shippingMode = $shippingMode;

        return $this;
    }

    /**
     * Get shippingMode
     *
     * @return string
     */
    public function getShippingMode()
    {
        return $this->shippingMode;
    }

    /**
     * Set shippingCost
     *
     * @param string $shippingCost
     *
     * @return Commande
     */
    public function setShippingCost($shippingCost)
    {
        $this->shippingCost = $shippingCost;

        return $this;
    }

    /**
     * Get shippingCost
     *
     * @return string
     */
    public function getShippingCost()
    {
        return $this->shippingCost;
    }
}
