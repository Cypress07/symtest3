<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $foodCategory = new Category();
        $foodCategory->setName('Nourriture')->setVatRate(Category::REDUCED_VAT_RATE_55);
        $manager->persist($foodCategory);

        $gamesCategory = new Category();
        $gamesCategory->setName('Jeux')->setVatRate(Category::STANDARD_VAT_RATE);
        $manager->persist($gamesCategory);

        $manager->flush();
        

        $this->addReference('games-category', $gamesCategory);
        $this->addReference('food-category', $foodCategory);
       
    }
}
