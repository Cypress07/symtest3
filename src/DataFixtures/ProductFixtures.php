<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

class ProductFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('God of War')
                ->setDescription('Le joueur incarne un redoutable guerrier, Kratos, qui se retrouve confronté à un grand nombre d\'ennemis')
                ->setPrice (69)
                ->setCategory($this->getReference('games-category'));
        
        $manager->persist($product);

        $manager->flush();
    }
        
    /**
     * This method ùust return an array of tixtures classes
     * on which the implementing class depends on
     * 
     *  @return array
     */

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
    
}
