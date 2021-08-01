<?php

namespace App\Entity\Shopware;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 *
 * @ORM\Table(name="s_order_details")
 * @ORM\Entity()
 */
class OrderDetail
{
    /**
     * @var \App\Entity\Shopware\Order
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Shopware\Order", inversedBy="details")
     * @ORM\JoinColumn(name="orderID", referencedColumnName="id")
     */
    protected Order $order;

    /**
     * @param \App\Entity\Shopware\Order $order
     */
    public function setOrder(Order $order): void
    {
        $this->order = $order;
    }

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * @var int
     *
     * @ORM\Column(name="orderID", type="integer", nullable=false)
     */
    private int $orderId;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="articleID", type="integer", nullable=false)
     */
    private int $articleId;

    /**
     * @var int
     *
     * @ORM\Column(name="taxID", type="integer", nullable=false)
     */
    private int $taxId;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="tax_rate", type="float", nullable=false)
     */
    private float $taxRate;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private int $statusId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="articleDetailID", type="integer", nullable=true)
     */
    private ?int $articleDetailID;

    /**
     * @var string|null
     *
     * @ORM\Column(name="ordernumber", type="string", length=255, nullable=true)
     */
    private ?string $number;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="articleordernumber", type="string", length=255, nullable=false)
     */
    private string $articleNumber;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="price", type="float", nullable=false)
     */
    private float $price;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="quantity", type="integer", nullable=false)
     */
    private int $quantity;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private string $articleName;

    /**
     * @var int
     *
     * @ORM\Column(name="shipped", type="integer", nullable=false)
     */
    private int $shipped = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="shippedgroup", type="integer", nullable=false)
     */
    private int $shippedGroup = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="modus", type="integer", nullable=false)
     */
    private int $mode = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="esdarticle", type="integer", nullable=false)
     */
    private int $esdArticle = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="config", type="text", nullable=false)
     */
    private string $config = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="ean", type="string", length=255, nullable=true)
     */
    private ?string $ean;

    /**
     * @var string|null
     *
     * @ORM\Column(name="unit", type="string", length=255, nullable=true)
     */
    private ?string $unit;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pack_unit", type="string", length=255, nullable=true)
     */
    private ?string $packUnit;

    /**
     * @return \App\Entity\Shopware\Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getOrderId(): int
    {
        return $this->orderId;
    }

    /**
     * @return int
     */
    public function getArticleId(): int
    {
        return $this->articleId;
    }

    /**
     * @return int
     */
    public function getTaxId(): int
    {
        return $this->taxId;
    }

    /**
     * @return float
     */
    public function getTaxRate(): float
    {
        return $this->taxRate;
    }

    /**
     * @return int
     */
    public function getStatusId(): int
    {
        return $this->statusId;
    }

    /**
     * @return int|null
     */
    public function getArticleDetailID(): ?int
    {
        return $this->articleDetailID;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return string
     */
    public function getArticleNumber(): string
    {
        return $this->articleNumber;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }

    /**
     * @return string
     */
    public function getArticleName(): string
    {
        return $this->articleName;
    }

    /**
     * @return int
     */
    public function getShipped(): int
    {
        return $this->shipped;
    }

    /**
     * @return int
     */
    public function getShippedGroup(): int
    {
        return $this->shippedGroup;
    }

    /**
     * @return int
     */
    public function getMode(): int
    {
        return $this->mode;
    }

    /**
     * @return int
     */
    public function getEsdArticle(): int
    {
        return $this->esdArticle;
    }

    /**
     * @return string
     */
    public function getConfig(): string
    {
        return $this->config;
    }

    /**
     * @return string|null
     */
    public function getEan(): ?string
    {
        return $this->ean;
    }

    /**
     * @return string|null
     */
    public function getUnit(): ?string
    {
        return $this->unit;
    }

    /**
     * @return string|null
     */
    public function getPackUnit(): ?string
    {
        return $this->packUnit;
    }

    /**
     * @param int $orderId
     */
    public function setOrderId(int $orderId): void
    {
        $this->orderId = $orderId;
    }

    /**
     * @param int $articleId
     */
    public function setArticleId(int $articleId): void
    {
        $this->articleId = $articleId;
    }

    /**
     * @param int $taxId
     */
    public function setTaxId(int $taxId): void
    {
        $this->taxId = $taxId;
    }

    /**
     * @param float $taxRate
     */
    public function setTaxRate(float $taxRate): void
    {
        $this->taxRate = $taxRate;
    }

    /**
     * @param int $statusId
     */
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    /**
     * @param int|null $articleDetailID
     */
    public function setArticleDetailID(?int $articleDetailID): void
    {
        $this->articleDetailID = $articleDetailID;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @param string $articleNumber
     */
    public function setArticleNumber(string $articleNumber): void
    {
        $this->articleNumber = $articleNumber;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }

    /**
     * @param string $articleName
     */
    public function setArticleName(string $articleName): void
    {
        $this->articleName = $articleName;
    }

    /**
     * @param int $shipped
     */
    public function setShipped(int $shipped): void
    {
        $this->shipped = $shipped;
    }

    /**
     * @param int $shippedGroup
     */
    public function setShippedGroup(int $shippedGroup): void
    {
        $this->shippedGroup = $shippedGroup;
    }

    /**
     * @param int $mode
     */
    public function setMode(int $mode): void
    {
        $this->mode = $mode;
    }

    /**
     * @param int $esdArticle
     */
    public function setEsdArticle(int $esdArticle): void
    {
        $this->esdArticle = $esdArticle;
    }

    /**
     * @param string $config
     */
    public function setConfig(string $config): void
    {
        $this->config = $config;
    }

    /**
     * @param string|null $ean
     */
    public function setEan(?string $ean): void
    {
        $this->ean = $ean;
    }

    /**
     * @param string|null $unit
     */
    public function setUnit(?string $unit): void
    {
        $this->unit = $unit;
    }

    /**
     * @param string|null $packUnit
     */
    public function setPackUnit(?string $packUnit): void
    {
        $this->packUnit = $packUnit;
    }
}
