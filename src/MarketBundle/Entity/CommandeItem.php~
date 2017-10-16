<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CommandeItem
 *
 * @ORM\Table(name="commande_item")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\CommandeItemRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class CommandeItem
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
     * @var int
     *
     * @ORM\Column(name="quantity", type="integer")
     */
    private $quantity;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="items")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $product;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Commande", inversedBy="items")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $commande;

    /**
     * @ORM\PreRemove
     */
    public function preRemove() {
        if($this->commande) {
            $this->commande->setTotal($this->commande->getTotal() - ($this->getQuantity() * $this->product->getPrice()));
        }
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
     * Set quantity
     *
     * @param integer $quantity
     *
     * @return CommandeItem
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
     * Set product
     *
     * @param \MarketBundle\Entity\ProductVariant $product
     *
     * @return CommandeItem
     */
    public function setProduct(\MarketBundle\Entity\ProductVariant $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \MarketBundle\Entity\ProductVariant
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set commande
     *
     * @param \MarketBundle\Entity\Commande $commande
     *
     * @return CommandeItem
     */
    public function setCommande(\MarketBundle\Entity\Commande $commande = null)
    {
        $this->commande = $commande;

        return $this;
    }

    /**
     * Get commande
     *
     * @return \MarketBundle\Entity\Commande
     */
    public function getCommande()
    {
        return $this->commande;
    }
}
