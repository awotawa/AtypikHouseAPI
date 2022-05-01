<?php

namespace App\DataFixtures;


use App\Entity\Message;
use DateTime;
use DateTimeInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class MessageFixtures extends Fixture implements DependentFixtureInterface
{

	public function getDependencies()
	{
		return [
			UserFixtures::class,
			OwnerFixtures::class,
		];
	}

	public function load(ObjectManager $manager)
	{

		$faker = Faker\Factory::create("fr_FR");

		for ($i = 0; $i < 5; $i++) {

			$message = new Message();
			$message->setUserId($this->getReference("USER".mt_rand(0, 9)));
			$message->setOwnerId($this->getReference("OWNER".mt_rand(0, 4)));
			$message->setMessageContent($faker->sentence());
			$message->setUpdatedAt($faker->dateTime());
			$manager->persist($message);
		}


		// for ($i = 5; $i < 9; $i++) {

		// 	$message = new Message();
		// 	$message->setMessageContent($faker->sentence());
		// 	$message->setCreatedAt($faker->dateTime());
		// 	$message->setUpdatedAt($faker->dateTime());
		// 	$manager->persist($message);
		// }


		$manager->flush();
	}
}
