<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $category = new Category();
        $category->setName("Maths");

        $category2 = new Category();
        $category2->setName("History");

        $category3 = new Category();
        $category3->setName("Biology");

        $manager->persist($category);
        $manager->persist($category2);
        $manager->persist($category3);

        $manager->flush();
    }
}