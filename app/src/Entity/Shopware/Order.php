<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace App\Entity\Shopware;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="s_order")
 */
class Order
{
    /**
     * @return \App\Entity\Shopware\Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @var \App\Entity\Shopware\Customer
     *
     * @ORM\ManyToOne(targetEntity="\App\Entity\Shopware\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="userID", referencedColumnName="id")
     */
    protected Customer $customer;

    /**
     * Unique identifier field.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;

    /**
     * Time of the last modification of the order
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="changed", type="datetime", nullable=false)
     */
    private $changed;

    /**
     * Contains the alphanumeric order number. If the
     *
     * @var string|null
     *
     * @ORM\Column(name="ordernumber", type="string", length=255, nullable=true)
     */
    private $number;

    /**
     * @var int
     *
     * @ORM\Column(name="userID", type="integer", nullable=false)
     */
    private $customerId;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

    /**
     * @var int
     *
     * @ORM\Column(name="cleared", type="integer", nullable=false)
     */
    private $cleared;

    /**
     * @var int
     *
     * @ORM\Column(name="paymentID", type="integer", nullable=false)
     */
    private $paymentId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="dispatchID", type="integer", nullable=true)
     */
    private $dispatchId;

    /**
     * @var string
     *
     * @ORM\Column(name="partnerID", type="string", length=255, nullable=false)
     */
    private $partnerId;

    /**
     * @var int
     *
     * @ORM\Column(name="subshopID", type="integer", nullable=false)
     */
    private $shopId;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="invoice_amount", type="float", nullable=false)
     */
    private $invoiceAmount;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="invoice_amount_net", type="float", nullable=false)
     */
    private $invoiceAmountNet;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="invoice_shipping", type="float", nullable=false)
     */
    private $invoiceShipping;

    /**
     * @var float
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="invoice_shipping_net", type="float", nullable=false)
     */
    private $invoiceShippingNet;

    /**
     * @var float|null
     *
     * @ORM\Column(name="invoice_shipping_tax_rate", type="decimal", nullable=true)
     */
    private $invoiceShippingTaxRate;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="ordertime", type="datetime", nullable=false)
     */
    private $orderTime = null;

    /**
     * @var string
     *
     * @ORM\Column(name="transactionID", type="string", length=255, nullable=false)
     */
    private $transactionId;

    /**
     * @var string
     *
     * @ORM\Column(name="comment", type="text", nullable=false)
     */
    private $comment;

    /**
     * @var string
     *
     * @ORM\Column(name="customercomment", type="text", nullable=false)
     */
    private $customerComment;

    /**
     * @var string
     *
     * @ORM\Column(name="internalcomment", type="text", nullable=false)
     */
    private $internalComment;

    /**
     * @Assert\NotBlank()
     *
     * @var int
     *
     * @ORM\Column(name="net", type="integer", nullable=false)
     */
    private $net;

    /**
     * @var int
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="taxfree", type="integer", nullable=false)
     */
    private $taxFree;

    /**
     * @var string
     *
     * @ORM\Column(name="temporaryID", type="string", length=255, nullable=false)
     */
    private $temporaryId;

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="text", nullable=false)
     */
    private $referer;

    /**
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="cleareddate", type="datetime", nullable=true)
     */
    private $clearedDate = null;

    /**
     * @var string
     *
     * @ORM\Column(name="trackingcode", type="text", nullable=false)
     */
    private $trackingCode;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="language", type="string", length=10, nullable=false)
     */
    private $languageIso;

    /**
     * @var string
     *
     * @ORM\Column(name="currency", type="string", length=5, nullable=false)
     * @Assert\NotBlank()
     */
    private $currency;

    /**
     * @var float
     *
     * @ORM\Column(name="currencyfactor", type="float", nullable=false)
     * @Assert\NotBlank()
     */
    private $currencyFactor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="remote_addr", type="string", length=255, nullable=true)
     */
    private $remoteAddress;

    /**
     * @var string|null
     *
     * @ORM\Column(name="deviceType", type="string", length=50, nullable=true)
     */
    private $deviceType = 'desktop';

    /**
     * @var bool
     *
     * @ORM\Column(name="is_proportional_calculation", type="boolean", nullable=false)
     */
    private $isProportionalCalculation = false;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getChanged(): \DateTimeInterface
    {
        return $this->changed;
    }

    /**
     * @param \DateTimeInterface $changed
     */
    public function setChanged(\DateTimeInterface $changed): void
    {
        $this->changed = $changed;
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @param string|null $number
     */
    public function setNumber(?string $number): void
    {
        $this->number = $number;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
    }

    /**
     * @param int $customerId
     */
    public function setCustomerId(int $customerId): void
    {
        $this->customerId = $customerId;
    }

    /**
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @param int $status
     */
    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return int
     */
    public function getCleared(): int
    {
        return $this->cleared;
    }

    /**
     * @param int $cleared
     */
    public function setCleared(int $cleared): void
    {
        $this->cleared = $cleared;
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @param int $paymentId
     */
    public function setPaymentId(int $paymentId): void
    {
        $this->paymentId = $paymentId;
    }

    /**
     * @return string|null
     */
    public function getDispatchId(): ?string
    {
        return $this->dispatchId;
    }

    /**
     * @param string|null $dispatchId
     */
    public function setDispatchId(?string $dispatchId): void
    {
        $this->dispatchId = $dispatchId;
    }

    /**
     * @return string
     */
    public function getPartnerId(): string
    {
        return $this->partnerId;
    }

    /**
     * @param string $partnerId
     */
    public function setPartnerId(string $partnerId): void
    {
        $this->partnerId = $partnerId;
    }

    /**
     * @return int
     */
    public function getShopId(): int
    {
        return $this->shopId;
    }

    /**
     * @param int $shopId
     */
    public function setShopId(int $shopId): void
    {
        $this->shopId = $shopId;
    }

    /**
     * @return float
     */
    public function getInvoiceAmount(): float
    {
        return $this->invoiceAmount;
    }

    /**
     * @param float $invoiceAmount
     */
    public function setInvoiceAmount(float $invoiceAmount): void
    {
        $this->invoiceAmount = $invoiceAmount;
    }

    /**
     * @return float
     */
    public function getInvoiceAmountNet(): float
    {
        return $this->invoiceAmountNet;
    }

    /**
     * @param float $invoiceAmountNet
     */
    public function setInvoiceAmountNet(float $invoiceAmountNet): void
    {
        $this->invoiceAmountNet = $invoiceAmountNet;
    }

    /**
     * @return float
     */
    public function getInvoiceShipping(): float
    {
        return $this->invoiceShipping;
    }

    /**
     * @param float $invoiceShipping
     */
    public function setInvoiceShipping(float $invoiceShipping): void
    {
        $this->invoiceShipping = $invoiceShipping;
    }

    /**
     * @return float
     */
    public function getInvoiceShippingNet(): float
    {
        return $this->invoiceShippingNet;
    }

    /**
     * @param float $invoiceShippingNet
     */
    public function setInvoiceShippingNet(float $invoiceShippingNet): void
    {
        $this->invoiceShippingNet = $invoiceShippingNet;
    }

    /**
     * @return float|null
     */
    public function getInvoiceShippingTaxRate(): ?float
    {
        return $this->invoiceShippingTaxRate;
    }

    /**
     * @param float|null $invoiceShippingTaxRate
     */
    public function setInvoiceShippingTaxRate(?float $invoiceShippingTaxRate): void
    {
        $this->invoiceShippingTaxRate = $invoiceShippingTaxRate;
    }

    /**
     * @return ?string
     */
    public function getOrderTime(): ?string
    {
        return $this->orderTime->format('d-m-Y H:i:s');
    }

    /**
     * @param \DateTimeInterface $orderTime
     */
    public function setOrderTime(?\DateTimeInterface $orderTime): void
    {
        $this->orderTime = $orderTime;
    }

    /**
     * @return string
     */
    public function getTransactionId(): string
    {
        return $this->transactionId;
    }

    /**
     * @param string $transactionId
     */
    public function setTransactionId(string $transactionId): void
    {
        $this->transactionId = $transactionId;
    }

    /**
     * @return string
     */
    public function getComment(): string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     */
    public function setComment(string $comment): void
    {
        $this->comment = $comment;
    }

    /**
     * @return string
     */
    public function getCustomerComment(): string
    {
        return $this->customerComment;
    }

    /**
     * @param string $customerComment
     */
    public function setCustomerComment(string $customerComment): void
    {
        $this->customerComment = $customerComment;
    }

    /**
     * @return string
     */
    public function getInternalComment(): string
    {
        return $this->internalComment;
    }

    /**
     * @param string $internalComment
     */
    public function setInternalComment(string $internalComment): void
    {
        $this->internalComment = $internalComment;
    }

    /**
     * @return int
     */
    public function getNet(): int
    {
        return $this->net;
    }

    /**
     * @param int $net
     */
    public function setNet(int $net): void
    {
        $this->net = $net;
    }

    /**
     * @return int
     */
    public function getTaxFree(): int
    {
        return $this->taxFree;
    }

    /**
     * @param int $taxFree
     */
    public function setTaxFree(int $taxFree): void
    {
        $this->taxFree = $taxFree;
    }

    /**
     * @return string
     */
    public function getTemporaryId(): string
    {
        return $this->temporaryId;
    }

    /**
     * @param string $temporaryId
     */
    public function setTemporaryId(string $temporaryId): void
    {
        $this->temporaryId = $temporaryId;
    }

    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $this->referer;
    }

    /**
     * @param string $referer
     */
    public function setReferer(string $referer): void
    {
        $this->referer = $referer;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getClearedDate(): ?\DateTimeInterface
    {
        return $this->clearedDate;
    }

    /**
     * @param \DateTimeInterface|null $clearedDate
     */
    public function setClearedDate(?\DateTimeInterface $clearedDate): void
    {
        $this->clearedDate = $clearedDate;
    }

    /**
     * @return string
     */
    public function getTrackingCode(): string
    {
        return $this->trackingCode;
    }

    /**
     * @param string $trackingCode
     */
    public function setTrackingCode(string $trackingCode): void
    {
        $this->trackingCode = $trackingCode;
    }

    /**
     * @return string
     */
    public function getLanguageIso(): string
    {
        return $this->languageIso;
    }

    /**
     * @param string $languageIso
     */
    public function setLanguageIso(string $languageIso): void
    {
        $this->languageIso = $languageIso;
    }

    /**
     * @return string
     */
    public function getCurrency(): string
    {
        return $this->currency;
    }

    /**
     * @param string $currency
     */
    public function setCurrency(string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @return float
     */
    public function getCurrencyFactor(): float
    {
        return $this->currencyFactor;
    }

    /**
     * @param float $currencyFactor
     */
    public function setCurrencyFactor(float $currencyFactor): void
    {
        $this->currencyFactor = $currencyFactor;
    }

    /**
     * @return string|null
     */
    public function getRemoteAddress(): ?string
    {
        return $this->remoteAddress;
    }

    /**
     * @param string|null $remoteAddress
     */
    public function setRemoteAddress(?string $remoteAddress): void
    {
        $this->remoteAddress = $remoteAddress;
    }

    /**
     * @return string|null
     */
    public function getDeviceType(): ?string
    {
        return $this->deviceType;
    }

    /**
     * @param string|null $deviceType
     */
    public function setDeviceType(?string $deviceType): void
    {
        $this->deviceType = $deviceType;
    }

    /**
     * @return bool
     */
    public function isProportionalCalculation(): bool
    {
        return $this->isProportionalCalculation;
    }

    /**
     * @param bool $isProportionalCalculation
     */
    public function setIsProportionalCalculation(bool $isProportionalCalculation): void
    {
        $this->isProportionalCalculation = $isProportionalCalculation;
    }
}
