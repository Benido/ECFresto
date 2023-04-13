<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $admin = new User();
        $admin->setEmail('admin@admin.fr');
        $admin->setRoles(["ROLE_ADMIN"]);
        $passwordAdmin = $this->hasher->hashPassword($admin, 'password');
        $admin->setPassword($passwordAdmin);
        $manager->persist($admin);

        $client = new User();
        $client->setEmail('client@client.fr');
        $passwordClient = $this->hasher->hashPassword($client, 'client');
        $client->setPassword($passwordClient);
        $manager->persist($client);

        $manager->flush();
    }
}
