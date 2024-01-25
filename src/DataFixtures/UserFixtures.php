<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\User;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserFixtures extends Fixture
{
    private UserPasswordHasherInterface $passwordEncoder;
    private $faker;

    public function __construct(UserPasswordHasherInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        // Création de trois utilisateurs Démo
        $this->createUser($manager, 'admin@example.com', 'Compte', 'Admin', ['ROLE_ADMIN'], 'adminpass');
        $this->createUser($manager, 'user@example.com', 'Compte', 'Utilisateur', ['ROLE_USER'], 'userpass');
        $this->createUser($manager, 'supplier@example.com', 'Compte', 'Fournisseur', ['ROLE_SUPPLIER'], 'supplierpass');

        // Création de cinq utilisateurs supplémentaires
        for ($i = 0; $i < 5; $i++) {
            $this->randomUser($manager);
        }

        $manager->flush();
    }

    private function createUser(ObjectManager $manager, string $email, string $firstname, string $lastname, array $roles, string $password): void
    {
        $user = new User();
        $user->setEmail($email);
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setRoles($roles);
        $user->setPassword($this->passwordEncoder->hashPassword($user, $password));
        $manager->persist($user);
    }

    private function randomUser(ObjectManager $manager): void
    {
        $email = $this->faker->unique()->safeEmail;
        $firstname = $this->faker->firstName;
        $lastname = $this->faker->lastName;
        $password = $this->faker->password;

        $this->createUser($manager, $email, $firstname, $lastname, ['ROLE_USER'], $password);
    }
}
