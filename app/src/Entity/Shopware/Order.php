<?php

namespace App\Entity\Shopware;

use App\Repository\OrderRepository;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;

/**
 * @ORM\Entity(repositoryClass=OrderRepository::class)
 * @ORM\Table(name="s_order")
 */
class Order
{
    /**
     * @var \App\Entity\Shopware\Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Shopware\Customer", inversedBy="orders")
     * @ORM\JoinColumn(name="userID", referencedColumnName="id")
     */
    protected Customer $customer;

    /**
     * INVERSE SIDE
     *
     * @var \Doctrine\ORM\PersistentCollection<\App\Entity\Shopware\OrderDetail>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Shopware\OrderDetail", mappedBy="order", orphanRemoval=true, cascade={"persist"})
     */
    protected PersistentCollection $details;

    /**
     * Unique identifier field.
     *
     * @var int
     *
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private int $id;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private int $status;

    /**
     * @var int
     *
     * @ORM\Column(name="userID", type="integer", nullable=false)
     */
    private int $customerId;

    /**
     * Contains the alphanumeric order number. If the
     *
     * @var string|null
     *
     * @ORM\Column(name="ordernumber", type="string", length=255, nullable=true)
     */
    private ?string $number;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="ordertime", type="datetime", nullable=false)
     */
    private DateTimeInterface $orderTime;

    /**
     * @return string
     */
    public function getOrderTime(): string
    {
        return $this->orderTime->format('d-m-Y H:i:s');
    }

    /**
     * @return string|null
     */
    public function getNumber(): ?string
    {
        return $this->number;
    }

    /**
     * @return int
     */
    public function getCustomerId(): int
    {
        return $this->customerId;
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
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * @return PersistentCollection
     */
    public function getDetails(): PersistentCollection
    {
        return $this->details;
    }

    /**
     * @return \App\Entity\Shopware\Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }
}
