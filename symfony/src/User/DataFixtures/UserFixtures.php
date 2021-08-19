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
        $user->setRoles(['ROLE_ADMIN']);
        $user->setPassword($this->passwordEncoder->encodePassword($user, '123qwe'));
        $manager->persist($user);

        $user1 = new User();
        $user1->setEmail('user@local');
        $user1->setFirstName('Użytkownik');
        $user1->setLastName('Systemu');
        $user1->setRoles(['ROLE_USER']);
        $user1->setPassword($this->passwordEncoder->encodePassword($user1, '123qwe'));
        $manager->persist($user1);
        $manager->flush();
    }

}
