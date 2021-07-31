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

use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

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
            default => 'Unknown'
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
