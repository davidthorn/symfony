<?php

namespace App\DataFixtures\Core;

use App\Entity\Core\User;
use App\Security\Roles;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
final class UsersFixtures extends Fixture
{
    /**
     * @var \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface
     */
    protected UserPasswordEncoderInterface $userPasswordEncoder;

    /**
     * @param \Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface $userPasswordEncoder
     */
    public function __construct(UserPasswordEncoderInterface $userPasswordEncoder)
    {
        $this->userPasswordEncoder = $userPasswordEncoder;
    }

    /**
     * @param \Doctrine\Persistence\ObjectManager $manager
     */
    public function load(ObjectManager $manager)
    {
        $users = [
            [
                'username' => 'jamesthorn',
                'roles' => [Roles::USER],
                'password' => '123456'
            ],
            [
                'username' => 'admin',
                'roles' => [Roles::USER, Roles::ADMIN],
                'password' => '123456'
            ],
            [
                'username' => 'davidthorn',
                'roles' => [Roles::USER, Roles::ADMIN, Roles::SUPER_ADMIN],
                'password' => '123456'
            ]
        ];

        foreach ($users as $info) {
            $user = new User();
            $user->setUsername($info['username']);
            $user->setRoles($info['roles']);
            $user->setPassword($this->userPasswordEncoder->encodePassword($user, $info['password']));
            $manager->persist($user);
        }

        $manager->flush();
    }
}
