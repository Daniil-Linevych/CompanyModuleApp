<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final class UserFixtures extends Fixture
{
    public const USER_TIM        = 'user-tim';
    public const USER_SUNDAR     = 'user-sundar';
    public const USER_REED       = 'user-reed';
    public const USER_DANIEL     = 'user-daniel';
    public const USER_BRIAN      = 'user-brian';
    public const USER_ELON       = 'user-elon';
    public const USER_JENSEN     = 'user-jensen';
    public const USER_SATYA      = 'user-satya';

    public const PASSWORD =  '123123';

    private const USERS = [
        ['email' => 'tim.cook@apple.com',       'reference' => self::USER_TIM],
        ['email' => 'sundar.pichai@google.com',  'reference' => self::USER_SUNDAR],
        ['email' => 'reed.hastings@netflix.com', 'reference' => self::USER_REED],
        ['email' => 'daniel.ek@spotify.com',     'reference' => self::USER_DANIEL],
        ['email' => 'brian.chesky@airbnb.com',   'reference' => self::USER_BRIAN],
        ['email' => 'elon.musk@tesla.com',       'reference' => self::USER_ELON],
        ['email' => 'jensen.huang@nvidia.com',   'reference' => self::USER_JENSEN],
        ['email' => 'satya.nadella@microsoft.com', 'reference' => self::USER_SATYA],
    ];

    public function __construct(
        private readonly UserPasswordHasherInterface $hasher,
    ) {
    }

    public function load(ObjectManager $manager): void
    {
        foreach (self::USERS as $data) {
            $user = new User();
            $user->setEmail($data['email']);
            $user->setRoles(['ROLE_USER']);
            $user->setPassword(
                $this->hasher->hashPassword($user, self::PASSWORD)
            );

            $manager->persist($user);
            $this->addReference($data['reference'], $user);
        }

        $manager->flush();
    }
}
