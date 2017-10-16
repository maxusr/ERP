<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductQuantity
 *
 * @ORM\Table(name="product_quantity")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\ProductQuantityRepository")
 * @ORM\HasLifecycleCallbacks()
 */
class ProductQuantity
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
     * @ORM\Column(name="insertedAt", type="datetimetz")
     */
    private $insertedAt;

    /**
     * @var string
     *
     * @ORM\Column(name="action", type="string", length=64)
     */
    private $action;

    /**
     * @var ProductVariant
     *
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="quantities")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $product;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->insertedAt = new \DateTime;
    }

    /**
     * @ORM\PrePersist
     */
    public function prePersist() {
        if($this->action){
            $this->product->setQuantity($this->product->getQuantity() + $this->quantity);
        }else{
            $this->product->setQuantity($this->product->getQuantity() - $this->quantity);
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
     * @return ProductQuantity
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
     * Set insertedAt
     *
     * @param \DateTime $insertedAt
     *
     * @return ProductQuantity
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
     * Set action
     *
     * @param string $action
     *
     * @return ProductQuantity
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * Get action
     *
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    public function actionReadable() {
        return $this->action ? 'Ajout' : 'Reduction';
    }

    /**
     * Set product
     *
     * @param \MarketBundle\Entity\ProductVariant $product
     *
     * @return ProductQuantity
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
}
