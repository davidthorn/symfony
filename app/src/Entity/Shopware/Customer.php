<?php

namespace App\Entity\Shopware;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Symfony\Component\Validator\Constraints as Assert;
use DateTimeInterface;

/**
 * @ORM\Entity(repositoryClass="CustomerRepository::class")
 * @ORM\Table(name="s_user")
 */
class Customer
{
    /**
     * INVERSE SIDE
     * The orders property is the inverse side of the association between customer and orders.
     * The association is joined over the customer id field and the userID field of the order.
     *
     * @var \Doctrine\ORM\PersistentCollection<\App\Entity\Shopware\Order>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Shopware\Order", mappedBy="customer")
     */
    protected PersistentCollection $orders;

    /**
     * The id property is an identifier property which means
     * doctrine associations can be defined over this field
     *
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id()
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private int $id;

    /**
     * Contains the customer email address which is used to send the order confirmation mail
     * or the newsletter.
     *
     * @var string
     *
     * @Assert\Email(strict=false)
     * @Assert\NotBlank()
     * @ORM\Column(name="email", type="string", length=70, nullable=false)
     */
    private string $email;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="salutation", type="text", nullable=false)
     */
    private string $salutation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    private string $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="firstname", type="text", nullable=false)
     */
    private string $firstname;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="lastname", type="text", nullable=false)
     */
    private string $lastname;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getSalutation(): string
    {
        return match ($this->salutation) {
            'mr' => 'Mr',
            'mrs' => 'Mrs',
            'miss' => 'Miss',
            'ms' => 'Ms',
            'none' => 'None Provided',
            default => $this->salutation
        };
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return sprintf('%s %s %s',
            $this->getSalutation(),
            $this->getFirstname(),
            $this->getLastname()
        );
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @param string $salutation
     */
    public function setSalutation(string $salutation): void
    {
        $this->salutation = $salutation;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @param \DateTimeInterface $date
     * @param string $defaultFormat
     *
     * @return string
     */
    private function formatDate(DateTimeInterface $date, string $defaultFormat = 'd-m-Y H:i:s'): string
    {
        return $date->format($defaultFormat);
    }
}
