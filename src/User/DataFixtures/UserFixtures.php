<?php

namespace App\User\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use App\User\Entity\User;

class UserFixtures extends Fixture {

    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder) {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123qwe'));
        $manager->persist($user);
        $manager->flush();
    }

}
