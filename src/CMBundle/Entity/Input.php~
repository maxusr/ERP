<?php

namespace CMBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entry
 *
 * @ORM\Table(name="input")
 * @ORM\Entity(repositoryClass="CMBundle\Repository\InputRepository")
 * @ORM\HasLifecycleCallbacks
 */
class Input
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
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     */
    private $createdAt;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="inputs")
     */
    private $product;

    /**
     * @var Borrower
     *
     * @ORM\OneToOne(targetEntity="Borrower", inversedBy="input", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=true)
     */
    private $borrower;

    /**
     * @var CoreBundle\Entity\User
     *
     * @ORM\ManyToOne(targetEntity="CoreBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $employeeBorrower;

    /**
     * @var CoreBundle\Entity\User
     *
     * @ORM\OneToOne(targetEntity="CoreBundle\Entity\User")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $saver;

    public function __construct() {
        $this->createdAt = new \DateTime;
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
     * @return Entry
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
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Entry
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set product
     *
     * @param \CMBundle\Entity\Product $product
     *
     * @return Input
     */
    public function setProduct(\CMBundle\Entity\Product $product = null)
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get product
     *
     * @return \CMBundle\Entity\Product
     */
    public function getProduct()
    {
        return $this->product;
    }

    /**
     * Set borrower
     *
     * @param \CMBundle\Entity\Borrower $borrower
     *
     * @return Input
     */
    public function setBorrower(\CMBundle\Entity\Borrower $borrower = null)
    {
        $this->borrower = $borrower;

        return $this;
    }

    /**
     * Get borrower
     *
     * @return \CMBundle\Entity\Borrower
     */
    public function getBorrower()
    {
        return $this->borrower;
    }

    /**
     * Set employeeBorrower
     *
     * @param \CoreBundle\Entity\User $employeeBorrower
     *
     * @return Input
     */
    public function setEmployeeBorrower(\CoreBundle\Entity\User $employeeBorrower = null)
    {
        $this->employeeBorrower = $employeeBorrower;

        return $this;
    }

    /**
     * Get employeeBorrower
     *
     * @return \CoreBundle\Entity\User
     */
    public function getEmployeeBorrower()
    {
        return $this->employeeBorrower;
    }

    /**
     * Set saver
     *
     * @param \CoreBundle\Entity\User $saver
     *
     * @return Input
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
     *
     * @ORM\PrePersist()
     */
    public function prePersist() {
        $this->getProduct()->setQuantity($this->getProduct()->getQuantity() + $this->getQuantity());
    }

    /**
     *
     * @ORM\PreRemove()
     */
    public function preRemove() {
        $this->getProduct()->setQuantity($this->getProduct()->getQuantity() - $this->getQuantity());
    }
}
