<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    public function load(ObjectManager $manager)
    {
        foreach ($this->getUserData() as [$username, $password, $email, $roles]) {
            $user = new User();
            $user->setUsername($username);
            $user->setPassword($this->passwordEncoder->encodePassword($user, $password));
            $user->setEmail($email);
            $user->setRoles($roles);

            $manager->persist($user);
            $this->addReference($username, $user);
        }

        $manager->flush();
    }
    private function getUserData(): array
    {
        return [
            // $userData = [ $username, $password, $email, $roles];
            [ 'admin', 'admin', 'admin@admin.com', ['ROLE_ADMIN']],
            [ 'joris', 'testtest', 'joris@symfony.com', ['ROLE_USER']],
            ['michel', 'testtest', 'michel@symfony.com', ['ROLE_USER']],
        ];
    }
}
