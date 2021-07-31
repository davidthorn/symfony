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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Shopware\Components\Model\LazyFetchModelEntity;
use Shopware\Components\Model\ModelEntity;
use Shopware\Components\Security\AttributeCleanerTrait;
use Shopware\Models\Shop\Shop;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="CustomerRepository::class")
 * @ORM\Table(name="s_user")
 */
class Customer
{
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
    private $id;

    /**
     * Contains the unique customer number
     *
     * @var string|null
     *
     * @ORM\Column(name="customernumber", type="string", length=30, nullable=true)
     */
    protected $number = '';

    /**
     * Time of the last modification of the customer
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="changed", type="datetime", nullable=false)
     */
    private $changed;

    /**
     * Contains the id of the customer default payment method.
     * Used for the payment association.
     *
     * @var int
     *
     * @ORM\Column(name="paymentID", type="integer", nullable=false)
     */
    private $paymentId = 0;

    /**
     * Key of the assigned customer group.
     *
     * @var string
     *
     * @ORM\Column(name="customergroup", type="string", length=15, nullable=false)
     */
    private $groupKey = '';

    /**
     * Flag whether the customer account is activated.
     *
     * @var bool
     *
     * @ORM\Column(name="active", type="boolean", nullable=false)
     */
    private $active = 0;

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
    private $email;

    /**
     * Contains the date on which the customer account was created.
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="firstlogin", type="date", nullable=false)
     */
    private $firstLogin;

    /**
     * Contains the date on which the customer has logged in recently.
     *
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="lastlogin", type="datetime", nullable=false)
     */
    private $lastLogin;

    /**
     * Flag whether the customer checks the "don't create a shop account" checkbox
     *
     * @var int
     *
     * @ORM\Column(name="accountmode", type="integer", nullable=false)
     */
    private $accountMode = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="confirmationkey", type="string", length=100, nullable=false)
     */
    private $confirmationKey = '';

    /**
     * Flag whether the customer wishes to receive the store newsletter
     *
     * @var int
     *
     * @ORM\Column(name="newsletter", type="integer", nullable=false)
     */
    private $newsletter = 0;

    /**
     * Flag whether the customer is a shop partner.
     *
     * @var int
     *
     * @ORM\Column(name="affiliate", type="integer", nullable=false)
     */
    private $affiliate = 0;

    /**
     * Flag whether a payment default has been filed
     *
     * @var int
     *
     * @ORM\Column(name="paymentpreset", type="integer", nullable=false)
     */
    private $paymentPreset = 0;

    /**
     * @var string
     *
     * @ORM\Column(name="referer", type="string", length=255, nullable=false)
     */
    private $referer = '';

    /**
     * Count of the failed customer logins
     *
     * @var int
     *
     * @ORM\Column(name="failedlogins", type="integer", nullable=false)
     */
    private $failedLogins = 0;

    /**
     * Contains the time, since the customer is logged into a session.
     *
     * @var \DateTimeInterface|null
     *
     * @ORM\Column(name="lockedUntil", type="datetime", nullable=true)
     */
    private $lockedUntil;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     *
     * @ORM\Column(name="salutation", type="text", nullable=false)
     */
    private $salutation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="text", nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="firstname", type="text", nullable=false)
     */
    private $firstname;

    /**
     * @var string
     *
     * @Assert\NotBlank()
     * @ORM\Column(name="lastname", type="text", nullable=false)
     */
    private $lastname;

    /**
     * @var \DateTimeInterface
     *
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;

    /**
     * INVERSE SIDE
     * The orders property is the inverse side of the association between customer and orders.
     * The association is joined over the customer id field and the userID field of the order.
     *
     * @var ArrayCollection<\App\Entity\Shopware\Order>
     *
     * @ORM\OneToMany(targetEntity="App\Entity\Shopware\Order", mappedBy="customer")
     */
    protected $orders;

    /**
     * @return \Doctrine\Common\Collections\ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
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
    public function getChanged(): string
    {
        return $this->formatDate($this->changed);
    }

    /**
     * @return int
     */
    public function getPaymentId(): int
    {
        return $this->paymentId;
    }

    /**
     * @return string
     */
    public function getGroupKey(): string
    {
        return $this->groupKey;
    }

    /**
     * @return bool
     */
    public function isActive(): bool|int
    {
        return $this->active;
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
    public function getFirstLogin(): string
    {
        return $this->formatDate($this->firstLogin);
    }

    /**
     * @return string
     */
    public function getLastLogin(): string
    {
        return $this->formatDate($this->lastLogin);
    }

    /**
     * @return int
     */
    public function getAccountMode(): int
    {
        return $this->accountMode;
    }

    /**
     * @return string
     */
    public function getConfirmationKey(): string
    {
        return $this->confirmationKey;
    }

    /**
     * @return int
     */
    public function getNewsletter(): int
    {
        return $this->newsletter;
    }

    /**
     * @return int
     */
    public function getAffiliate(): int
    {
        return $this->affiliate;
    }

    /**
     * @return int
     */
    public function getPaymentPreset(): int
    {
        return $this->paymentPreset;
    }

    /**
     * @return string
     */
    public function getReferer(): string
    {
        return $this->referer;
    }

    /**
     * @return int
     */
    public function getFailedLogins(): int
    {
        return $this->failedLogins;
    }

    /**
     * @return string
     */
    public function getLockedUntil(): string
    {
        return $this->formatDate($this->lockedUntil);
    }

    /**
     * @return string
     */
    public function getSalutation(): string
    {
        return $this->salutation;
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
    public function getBirthday(): string
    {
        return $this->formatDate($this->birthday, 'd-m-Y');
    }

    /**
     * @return string
     */
    public function getFullname(): string
    {
        return printf('%s %s %s',
            $this->getSalutation(),
            $this->getFirstname(),
            $this->getLastname()
        );
    }

    /**
     * @param \DateTimeInterface $date
     * @param string $defaultFormat
     *
     * @return string
     */
    private function formatDate(\DateTimeInterface $date, string $defaultFormat = 'd-m-Y H:i:s'): string
    {
        return $date->format($defaultFormat);
    }
}
