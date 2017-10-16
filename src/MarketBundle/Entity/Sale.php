<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sale
 *
 * @ORM\Table(name="sale")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\SaleRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class Sale
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
     * @var \DateTime
     *
     * @ORM\Column(name="date", type="datetimetz")
     */
    private $date;

    /**
     * @var string
     *
     * @ORM\Column(name="total", type="string", length=24)
     */
    private $total;

    /**
     * @var string
     *
     * @ORM\Column(name="taxe", type="string", length=24)
     */
    private $taxe;

    /**
     * @var string
     *
     * @ORM\Column(name="totalTTC", type="string", length=24)
     */
    private $totalTTC;

    /**
     * @var string
     *
     * @ORM\Column(name="receive", type="string", length=24)
     */
    private $receive;

    /**
     * @var bool
     *
     * @ORM\Column(name="paid", type="boolean")
     */
    private $paid;

    /**
     * @var Commande
     *
     * @ORM\OneToOne(targetEntity="Commande")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $firstCommande;

    /**
     * @var ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Commande", mappedBy="sale")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $commandes;

    /**
     * @ORM\PrePersist
     * @ORM\PreUpdate
     */
    public function prePersist() {
        $this->total = 0;
        $this->totalTTC = 0;

        $this->taxe = str_replace(',', '.', $this->taxe);

        if(current($this->commandes))
            //$this->firstCommande = current($this->commandes);

        foreach ($this->commandes as $key => $commande) {
            $this->total += $commande->getTotal();
        }

        $this->estimateTotalTTC();
    }

    public function estimateTotalTTC() {
        if($this->total > 0){
            $this->totalTTC = $this->total + ($this->total * $this->taxe / 100);
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
     * Set date
     *
     * @param \DateTime $date
     *
     * @return Sale
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
     * Set total
     *
     * @param string $total
     *
     * @return Sale
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
     * Set taxe
     *
     * @param string $taxe
     *
     * @return Sale
     */
    public function setTaxe($taxe)
    {
        $this->taxe = $taxe;

        return $this;
    }

    /**
     * Get taxe
     *
     * @return string
     */
    public function getTaxe()
    {
        return $this->taxe;
    }

    /**
     * Set totalTTC
     *
     * @param string $totalTTC
     *
     * @return Sale
     */
    public function setTotalTTC($totalTTC)
    {
        $this->totalTTC = $totalTTC;

        return $this;
    }

    /**
     * Get totalTTC
     *
     * @return string
     */
    public function getTotalTTC()
    {
        return $this->totalTTC;
    }

    /**
     * Set receive
     *
     * @param string $receive
     *
     * @return Sale
     */
    public function setReceive($receive)
    {
        $this->receive = $receive;

        return $this;
    }

    /**
     * Get receive
     *
     * @return string
     */
    public function getReceive()
    {
        return $this->receive;
    }
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->commandes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->taxe = "19.25";
        $this->date = new \DateTime;
    }

    /**
     * Set paid
     *
     * @param boolean $paid
     *
     * @return Sale
     */
    public function setPaid($paid)
    {
        $this->paid = $paid;

        return $this;
    }

    /**
     * Get paid
     *
     * @return boolean
     */
    public function getPaid()
    {
        return $this->paid;
    }

    /**
     * Set firstCommande
     *
     * @param \MarketBundle\Entity\Commande $firstCommande
     *
     * @return Sale
     */
    public function setFirstCommande(\MarketBundle\Entity\Commande $firstCommande = null)
    {
        $this->firstCommande = $firstCommande;

        return $this;
    }

    /**
     * Get firstCommande
     *
     * @return \MarketBundle\Entity\Commande
     */
    public function getFirstCommande()
    {
        return $this->firstCommande;
    }

    /**
     * Add commande
     *
     * @param \MarketBundle\Entity\Commande $commande
     *
     * @return Sale
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
}
