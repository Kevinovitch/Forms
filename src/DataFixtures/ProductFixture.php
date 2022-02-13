<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixture extends Fixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $product = new Product();
        $product->setName('Chewing Gum');
        $product->setPrice(2.5);

        $product2 = new Product();
        $product2->setName('Apple');
        $product2->setPrice(1.5);

        $manager->persist($product);
        $manager->persist($product2);

        $manager->flush();
    }
}