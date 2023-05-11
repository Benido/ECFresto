<?php

namespace App\DataFixtures;

use App\Entity\Allergen;
use App\Entity\BusinessHours;
use App\Entity\Dish;
use App\Entity\DishCategory;
use App\Entity\Formula;
use App\Entity\Menu;
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

    private array $allergens = ['pamplemousse', 'fruits à coque', 'crustacés', 'gluten', 'soja', 'ail', 'coriandre'];

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

    private array $categories = ['entrées', 'viandes', 'poissons', 'desserts'];

    private array $dishes = [
        [
            'title' => 'Gougères aux épinards',
            'description' => 'Chou pâtissier fourré de délicieux épinards fondants',
            'price' => 10.3,
            'categoryIndex' => 0,
            'allergensIndex' => 0
        ],
        [
            'title' => 'Sardines à l\'huile',
            'description' => 'Une boîte de sardine savamment ouverte devant vos yeux ébahis',
            'price' => 8,
            'categoryIndex' => 0,
            'allergensIndex' => 0
        ],
        [
            'title' => 'Tataki de lamantin ',
            'description' => 'Des cubes de mignons lamantins juste saisis à l\'extérieur',
            'price' => 24,
            'categoryIndex' => 2,
            'allergensIndex' => 6
        ],
        [
            'title' => 'Cuisse de girafe',
            'description' => 'Cuisse de girafe AOP braisée pendant 8h selon la méthode Franc-Comtoise',
            'price' => 30,
            'categoryIndex' => 1,
            'allergensIndex' => 6
        ],
        [
            'title' => 'Myrtille flambée',
            'description' => 'Une petite myrtille carbonisée au milieu d\'une grande assiette',
            'price' => 12,
            'categoryIndex' => 3,
            'allergensIndex' => 0
        ],
        [
            'title' => 'Cône Magnum Choco-Coco',
            'description' => 'Parce qu\'on sait se faire plaisir',
            'price' => 14.5,
            'categoryIndex' => 3,
            'allergensIndex' => 2
        ],
    ];

    private array $formulas = [
        [
            'title' => 'Formule déjeuner',
            'description' => 'Entrée + plat ou plat + dessert',
            'temporality' => null,
            'price' => 22.5
        ],
        [
            'title' => 'Formule dîner',
            'description' => 'Entrée + plat + dessert',
            'temporality' => 'du mardi au samedi',
            'price' => 30
        ],
        [
            'title' => 'Formule dégustation',
            'description' => 'Entrée + plat + dessert',
            'temporality' => 'du mardi au samedi',
            'price' => 65
        ],
    ];

    public function __construct(UserPasswordHasherInterface $hasher)
    {
        $this->hasher = $hasher;
    }

    public function load(ObjectManager $manager): void
    {
        $newAllergens = [];
        foreach($this->allergens as $item) {
            $allergen = new Allergen();
            $allergen->setTitle($item);
            $manager->persist($allergen);
            $newAllergens[] = $allergen;
        }

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
        $client->addAllergen($newAllergens[1]);
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
            $reservation->addAllergen($newAllergens[rand(0, count($newAllergens) - 1)]);
            $reservation->setComment($item['comment']);
            $manager->persist($reservation);
        }

        $newCategory = [];
        foreach($this->categories as $item) {
            $category = new DishCategory();
            $category->setTitle($item);
            $manager->persist($category);
            $newCategory[] = $category;
        }

        $newDishes = [];
        foreach($this->dishes as $item) {
            $dish = new Dish();
            $dish->setTitle($item['title']);
            $dish->setDescription($item['description']);
            $dish->setPrice(($item['price']));
            $dish->setCategory($newCategory[$item['categoryIndex']]);
            $dish->addAllergen($newAllergens[$item['allergensIndex']]);
            $manager->persist($dish);
            $newDishes[] = $dish;
        }

        $newFormulas = [];
        foreach($this->formulas as $item) {
            $formula = new Formula();
            $formula->setTitle($item['title']);
            $formula->setDescription($item['description']);
            $formula->setPrice(($item['price']));
            $formula->setTemporality($item['temporality']);
            $manager->persist($formula);
            $newFormulas[] = $formula;
        }


        $menu1 = new Menu();
        $menu1->setTitle('Menu du marché');
        $menu1->addFormula($newFormulas[0]);
        $menu1->addFormula($newFormulas[1]);
        foreach($newDishes as $item) {
            $menu1->addDish($item);
        }
        $manager->persist($menu1);

        $menu2 = new Menu();
        $menu2->setTitle('Menu dégustation');
        $menu2->addFormula($newFormulas[2]);
        for($i=0; $i<count($newDishes); $i = $i+2) {
            $menu2->addDish($newDishes[$i]);
        }
        $manager->persist($menu2);

        $manager->flush();
    }
}
