<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Wish;
use App\Repository\CategoryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{


    public function load(ObjectManager $manager)
    {
        $faker = \Faker\Factory::create("fr_FR");
        $Categories = ["Voyage & aventure", "Sport", "Divertissement", "Relations humaines", "Autres"];

        // Jeu de données Categories
        for ($i = 0; $i < count($Categories); $i++) {
            $Category = new Category();
            $Category->setName($Categories[$i]);
            $manager->persist($Category);
        }
        $manager->flush();

        // les categories existante en BDD :
        $allCategory = $manager->getRepository("App:Category")->findAll();

        // Jeu de données Wishes
        for ($i = 0; $i < 50; $i++) {
            $wish = new Wish();
            $wish->setTitle($faker->sentence());
            $wish->setDescription($faker->realText());
            $wish->setAuthor($faker->userName);
            $wish->setIsPublished($faker->boolean(90));
            $wish->setDateCreated($faker->dateTimeBetween('-2 years'));
            $wish->setLikes($faker->numberBetween(0, 30));
            $wish->setCategory($faker->randomElement($allCategory));
            $manager->persist($wish);
        }
        $manager->flush();


    }






}
