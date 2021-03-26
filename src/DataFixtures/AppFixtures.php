<?php

namespace App\DataFixtures;

use App\Entity\Category;
use App\Entity\Reaction;
use App\Entity\Wish;
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

        // les categories existantes en BDD :
        $allCategory = $manager->getRepository("App:Category")->findAll();

        // Jeu de données Wishes
        for ($i = 0; $i < 60; $i++) {
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

        // les wishes existantes en BDD :
        $wishes = $manager->getRepository(Wish::class)->findAll();

        // Jeu de données Reaction
        foreach ($wishes as $w) {
            for ($i = 0; $i < ($faker->numberBetween(0, 2)); $i++) {
                $reaction = new Reaction();
                $reaction->setMessage($faker->realText());
                $reaction->setUsername($faker->userName);
                $reaction->setDateCreated($faker->dateTimeBetween('-1 years'));
                $reaction->setWish($w);
                $manager->persist($reaction);
            }
        }
        $manager->flush();




    }






}
