<?php

namespace App\DataFixtures\Shopware;

use App\Entity\Shopware\Article;
use App\Entity\Shopware\Customer;
use App\Entity\Shopware\Order;
use App\Entity\Shopware\OrderDetail;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Faker\Factory;

class OrderFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker = Factory::create();

        // Article
        $article = new Article();
        $article->setName(ucwords(implode(' ', $faker->words(3))));
        $article->setActive(true);
        $manager->persist($article);
        $manager->flush();

        // @todo add article number to Article
        $articleNumber = $faker->randomNumber(6);

        // Customer
        $customer = new Customer();
        $customer->setFirstname($faker->firstName());
        $customer->setLastname($faker->lastName());
        $customer->setEmail(
            sprintf('%s.%s@%s',
                strtolower($customer->getFirstname()),
                strtolower($customer->getLastname()),
                $faker->safeEmailDomain()
            )
        );
        $customer->setSalutation($faker->title());
        $customer->setTitle($faker->jobTitle());
        $manager->persist($customer);
        $manager->flush();

        // Order
        $order = new Order();
        $order->setCustomer($customer);
        $order->setNumber(
            $faker->randomNumber(6)
        );
        $order->setOrderTime(new \DateTime());
        $order->setStatus(1);
        $manager->persist($order);
        $manager->flush();

        // Order Detail
        $detail = new OrderDetail();
        $detail->setArticleId($article->getId());
        $detail->setOrder($order);
        $detail->setNumber($order->getNumber());
        $detail->setArticleName($article->getName());
        $detail->setArticleNumber($articleNumber);
        $detail->setConfig('config');
        $detail->setEan($faker->randomNumber(4));
        $detail->setEsdArticle($faker->randomNumber(2));
        $detail->setMode(1);
        $detail->setOrderId($order->getId());
        $detail->setPackUnit('packunit-1');
        $detail->setPrice($faker->randomFloat(2));
        $detail->setQuantity($faker->randomNumber(2));
        $detail->setShipped(1);
        $detail->setShippedGroup(1);
        $detail->setTaxId(1);
        $detail->setTaxRate(19);
        $detail->setStatusId(1);
        $detail->setUnit(1);
        $manager->persist($detail);

        $manager->flush();
    }
}
