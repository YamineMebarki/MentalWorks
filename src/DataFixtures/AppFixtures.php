<?php

namespace App\DataFixtures;

use App\Entity\Website;
use App\Entity\Client;
use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $user = new User();
        $user->setEmail('test@test.com')
            ->setRoles('["ROLE_ADMIN"]')
            ->setPassword('$argon2i$v=19$m=65536,t=4,p=1$bWcubWkxdVZ6Z2hKbG1xTA$fEN7fLnfLe+vCo9al3eHHFurRJCekYsUDoZ2bRBt3iI');
        //password
        $manager->persist($user);
        $clients= Client::class;
        $faker = \Faker\Factory::create('en_EN');
        // $product = new Product();
        // $manager->persist($product);
        for ($i = 0; $i <= 50; $i++) {
            $client = new Client();
            $client->setName($faker->name())
                ->setEmail($faker->email())
                ->setNameBusiness($faker->company())
                ->setPhoneNumber('0605020301');
            $websites = new Website();
            $websites->setName($faker->name())
                ->setContent($faker->text(400))
                ->setPhp(7.0)
                ->setUrl($faker->url())
                ->setClient($client);

            $manager->persist($websites);
            $manager->persist($client);
        }
        $manager->flush();
    }

}
