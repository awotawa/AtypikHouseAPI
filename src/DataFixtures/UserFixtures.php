<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\User;

use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker;

class UserFixtures extends Fixture
{

	public function load(ObjectManager $manager)
	{
		$faker = Faker\Factory::create("fr_FR");

		for ($i=0; $i < 10; $i++) {

			$user = new User();
			$user->setFirstName($faker->firstName());
			$user->setLastName($faker->lastName());
			$user->setEmail($faker->email());
			$user->setPassword("Azertyuiop-".$i);
			$user->setPhoto($faker->url());
			$user->setRoles($faker->randomElement([['ROLE_USER'], ['ROLE_OWNER']]));
			$user->setUpdatedAt($faker->dateTime());
			$manager->persist($user);
			$this->addReference("USER".$i, $user);

		}

		$manager->flush();
	}
}
