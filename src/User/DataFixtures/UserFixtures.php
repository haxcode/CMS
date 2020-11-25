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

    /**
     * @return void
     */
    public function load(ObjectManager $manager) {
        $user = new User();
        $user->setEmail('admin@local');
        $user->setFirstName('Administrator');
        $user->setLastName('Systemu');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123qwe'));
        $manager->persist($user);

        $user = new User();
        $user->setEmail('user@local');
        $user->setFirstName('Użytkownik');
        $user->setLastName('Systemu');
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123qwe'));
        $manager->persist($user);
        $manager->flush();
    }

}
