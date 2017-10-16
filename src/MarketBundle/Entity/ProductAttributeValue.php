<?php

namespace MarketBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProductAttributeValue
 *
 * @ORM\Table(name="product_attribute_value_market")
 * @ORM\Entity(repositoryClass="MarketBundle\Repository\ProductAttributeValueRepository")
 */
class ProductAttributeValue
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
     * @ORM\Column(name="value", type="text")
     */
    private $value;

    /**
     * @var ProductVariant
     *
     * @ORM\ManyToOne(targetEntity="ProductVariant", inversedBy="attributeValues")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $product;

    /**
     * @var ProductAttribute
     *
     * @ORM\ManyToOne(targetEntity="ProductAttribute", inversedBy="values")
     * @ORM\JoinColumn(onDelete="SET NULL")
     */
    private $attribute;


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
     * Set value
     *
     * @param string $value
     *
     * @return ProductAttributeValue
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
     * Set product
     *
     * @param \MarketBundle\Entity\ProductVariant $product
     *
     * @return ProductAttributeValue
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
     * Set attribute
     *
     * @param \MarketBundle\Entity\ProductAttribute $attribute
     *
     * @return ProductAttributeValue
     */
    public function setAttribute(\MarketBundle\Entity\ProductAttribute $attribute = null)
    {
        $this->attribute = $attribute;

        return $this;
    }

    /**
     * Get attribute
     *
     * @return \MarketBundle\Entity\ProductAttribute
     */
    public function getAttribute()
    {
        return $this->attribute;
    }
}
