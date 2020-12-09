<?php

namespace App\DataFixtures;

use App\Entity\Role;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Faker;

class AppFixtures extends Fixture
{

    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $faker = Faker\Factory::create();

        $roleSuperAdmin = new Role();
        $roleSuperAdmin->setWording('super_admin');
        $manager->persist($roleSuperAdmin);

        $roleAdmin = new Role();
        $roleAdmin->setWording('admin');
        $manager->persist($roleAdmin);

        $roleCashier = new Role();
        $roleCashier->setWording('cashier');
        $manager->persist($roleCashier);

        $rolePartner = new Role();
        $rolePartner->setWording('partner');
        $manager->persist($rolePartner);

        $superadmin = new User();
        $superadmin->setFirstname($faker->firstName());
        $superadmin->setLastname($faker->lastName());
        $superadmin->setPhone($faker->phoneNumber());
        $superadmin->setEmail($faker->email());
        $superadmin->setPassword($this->encoder->encodePassword($superadmin, "superadmin"));
        $superadmin->setRole($roleSuperAdmin);
        $manager->persist($superadmin);

        for ($i=0; $i < 20; $i++) { 
            $admin = new User();
            $admin->setFirstname($faker->firstName());
            $admin->setLastname($faker->lastName());
            $admin->setPhone($faker->phoneNumber());
            $admin->setEmail($faker->email());
            $admin->setPassword($this->encoder->encodePassword($admin, "admin"));
            $admin->setRole($roleAdmin);
            $manager->persist($admin);

            $cashier = new User();
            $cashier->setFirstname($faker->firstName());
            $cashier->setLastname($faker->lastName());
            $cashier->setPhone($faker->phoneNumber());
            $cashier->setEmail($faker->email());
            $cashier->setPassword($this->encoder->encodePassword($cashier, "cashier"));
            $cashier->setRole($roleCashier);
            $manager->persist($cashier);
        }

        $manager->flush();
    }
}