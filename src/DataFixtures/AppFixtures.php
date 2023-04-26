<?php

namespace App\DataFixtures;

use App\Entity\BusinessHours;
use App\Entity\Reservation;
use App\Entity\Restaurant;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\Admin;
use App\Entity\Client;
use App\Enum\Weekdays;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    private UserPasswordHasherInterface $hasher;
    private array $businessHours = [
        [Weekdays::lundi, null, null],
        [Weekdays::mardi, '10:00', '23:00'],
        [Weekdays::mercredi, '10:00', '15:15'],
        [Weekdays::mercredi, '18:15', '23:00'],
        [Weekdays::jeudi, '09:30', '14:45'],
        [Weekdays::jeudi, '17:30', '23:00'],
        [Weekdays::vendredi, '10:00', '00:00'],
        [Weekdays::samedi, '10:00', '01:00'],
        [Weekdays::dimanche, '09:00', '23:00'],
    ];

    private array $reservations = [
        [
            'restaurant' => 1,
            'client' => null,
            'date' => '2023-05-12 12:15:00',
            'email' => 'email@email.email',
            'seats' => 5,
            'allergens' => ['crevettes', 'noix'],
            'comment' => null
        ],
        [
            'restaurant' => 1,
            'client' => null,
            'date' => '2023-05-17 19:30:00',
            'email' => 'email1@email1.email1',
            'seats' => 3,
            'allergens' => null,
            'comment' => 'près de la fenêtre svp'
        ],
        [
            'restaurant' => 1,
            'client' => null,
            'date' => '2023-05-18 10:00:00',
            'email' => 'email2@email2.email2',
            'seats' => 4,
            'allergens' => ['pamplemousse'],
            'comment' => 'pourrions-nous avoir des mimosas sur la table ?'
        ],
    ];

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
        $admin->setRoles(['ROLE_ADMIN']);
        $manager->persist($admin);

        $client = new Client();
        $client->setEmail('client@client.fr');
        $passwordClient = $this->hasher->hashPassword($client, 'client');
        $client->setPassword($passwordClient);
        $client->setRoles(['ROLE_CLIENT']);
        $client->setDefaultSeatsNumber(4);
        $client->setAllergens(['fruits à coque', 'pamplemousse']);
        $manager->persist($client);

        $restaurant = new Restaurant();
        $restaurant->setMaxCapacity(50);
        $manager->persist($restaurant);

        foreach($this->businessHours as $item) {
            $dailyHours = new BusinessHours();
            $dailyHours->setWeekday($item[0]);
            $dailyHours->setOpeningHour($item[1] ? new \DateTime($item[1]) : null);
            $dailyHours->setClosingHour($item[1] ? new \DateTime($item[2]) : null);
            $dailyHours->setRestaurant($restaurant);
            $manager->persist($dailyHours);
        }

        foreach($this->reservations as $item) {
            $reservation = new Reservation();
            $reservation->setRestaurant($restaurant);
            $reservation->setDate(new \DateTime($item['date']));
            $reservation->setEmail($item['email']);
            $reservation->setSeatsNumber($item['seats']);
            $reservation->setAllergens($item['allergens'] ?? []);
            $reservation->setComment($item['comment']);
            $manager->persist($reservation);
        }
        $manager->flush();
    }
}
