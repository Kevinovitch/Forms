<?php

namespace App\DataFixtures;

use App\Entity\Issue;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class IssueFixture extends Fixture
{

    /**
     * @param ObjectManager $manager
     * @return mixed
     */
    public function load(ObjectManager $manager)
    {
        $issue = new Issue();
        $issue->setName('The Original Issue');

        $issue2 = new Issue();
        $issue2->setName('Issue number two');

        $issue3 = new Issue();
        $issue3->setName('Issue number three');

        $manager->persist($issue);
        $manager->persist($issue2);
        $manager->persist($issue3);

        $manager->flush();


    }
}