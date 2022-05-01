<?php

namespace App\DataFixtures;

use App\Entity\Lodging;
use DateTime;
use DateTimeInterface;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class LodgingFixtures extends Fixture implements DependentFixtureInterface
{
	public function getDependencies()
	{
		return [
			OwnerFixtures::class,
			CategoryFixtures::class,
		];
	}

	public function load(ObjectManager $manager)
	{

		$faker = Faker\Factory::create("fr_FR");

		for ($i=0; $i < 20; $i++) {

			$lodging  = new Lodging();

			$lodging->setOwnerId($this->getReference("OWNER".mt_rand(0, 4)));
			$lodging->setCategoryId($this->getReference("CATEGORY".mt_rand(0, 19)));
			$lodging->setName($faker->userName());
			$lodging->setRate(mt_rand(1, 10));
			$lodging->setLodgingDescription($faker->paragraph(1, true));
			$lodging->setAdress($faker->sentence());
			$lodging->setCheckInTime($faker->dateTime());
			$lodging->setUpdatedAt($faker->dateTime());
			$manager->persist($lodging);
			$this->addReference("LODGING".$i, $lodging);

		}


		$manager->flush();
	}
}
