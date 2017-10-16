<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Salaire
 *
 * @ORM\Table(name="salaire")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\SalaireRepository")
 */
class Salaire
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
     * @ORM\Column(name="montant", type="bigint")
     */
    private $montant;

    /**
     * @var int
     *
     * @ORM\Column(name="date_paiement", type="smallint")
     */
    private $datePaiement;

    /**
     * @var int
     *
     * @ORM\Column(name="duration", type="smallint")
     */
    private $duration;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Taxe")
     */
    private $taxes;

    /**
     * @var Echelon
     *
     * @ORM\OneToOne(targetEntity="Echelon", mappedBy="salaire")
     */
    private $echelon;
    /**
     * Constructor
     */
    public function __construct()
    {
        $this->taxes = new \Doctrine\Common\Collections\ArrayCollection();
        $this->duration = 24;
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
     * Set montant
     *
     * @param integer $montant
     *
     * @return Salaire
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get montant
     *
     * @return integer
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set duration
     *
     * @param integer $duration
     *
     * @return Salaire
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get duration
     *
     * @return integer
     */
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * Add tax
     *
     * @param \CoreBundle\Entity\Taxe $tax
     *
     * @return Salaire
     */
    public function addTax(\CoreBundle\Entity\Taxe $tax)
    {
        $this->taxes[] = $tax;

        return $this;
    }

    /**
     * Remove tax
     *
     * @param \CoreBundle\Entity\Taxe $tax
     */
    public function removeTax(\CoreBundle\Entity\Taxe $tax)
    {
        $this->taxes->removeElement($tax);
    }

    /**
     * Get taxes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getTaxes()
    {
        return $this->taxes;
    }

    /**
     * Set echelon
     *
     * @param \CoreBundle\Entity\Echelon $echelon
     *
     * @return Salaire
     */
    public function setEchelon(\CoreBundle\Entity\Echelon $echelon = null)
    {
        $this->echelon = $echelon;

        return $this;
    }

    /**
     * Get echelon
     *
     * @return \CoreBundle\Entity\Echelon
     */
    public function getEchelon()
    {
        return $this->echelon;
    }

    public static function dates() {
        $dates = [];
        for ($i=1; $i < 32; $i++) { 
            $dates[$i]= $i;
        }

        return $dates;
    }

    /**
     * Set datePaiement
     *
     * @param integer $datePaiement
     *
     * @return Salaire
     */
    public function setDatePaiement($datePaiement)
    {
        $this->datePaiement = $datePaiement;

        return $this;
    }

    /**
     * Get datePaiement
     *
     * @return integer
     */
    public function getDatePaiement()
    {
        return $this->datePaiement;
    }
}
