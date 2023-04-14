<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Entity\Client;
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
        $admin = new Admin();
        $admin->setEmail('admin@admin.fr');
        $passwordAdmin = $this->hasher->hashPassword($admin, 'password');
        $admin->setPassword($passwordAdmin);
        $manager->persist($admin);

        $client = new Client();
        $client->setEmail('client@client.fr');
        $passwordClient = $this->hasher->hashPassword($client, 'client');
        $client->setPassword($passwordClient);
        $client->setDefaultSeatsNumber(4);
        $client->setAllergens(['fruits à coque', 'pamplemousse']);
        $manager->persist($client);

        $manager->flush();
    }
}
