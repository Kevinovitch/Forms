<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixture extends Fixture
{

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager): void
    {
        $user = new User();
        $user->setEmail('renard@hotmail.fr');
        $user->setPassword($this->passwordEncoder->encodePassword(
            $user,
            'vwc'
        ));

        $user->setUsername('Sylvie_Renard');

        $manager->persist($user);

        $manager->flush();
    }
}
