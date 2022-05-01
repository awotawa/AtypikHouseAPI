<?php

namespace App\DataFixtures;


use DateTime;
use App\Entity\Review;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ReviewFixtures extends Fixture implements DependentFixtureInterface
{

	public function getDependencies()
	{
		return [
			UserFixtures::class,
			OwnerFixtures::class,
			LodgingFixtures::class
		];
	}

	public function load(ObjectManager $manager)
	{

		$faker = Faker\Factory::create("fr_FR");

		for ($i=0; $i < 10; $i++) {

			$reviews = new Review();
			$reviews->setOwnerId($this->getReference("OWNER".mt_rand(0, 4)));
			$reviews->setLodgingId($this->getReference("LODGING".mt_rand(0, 19)));
			$reviews->setUserId($this->getReference("USER".mt_rand(1, 8)));
			$reviews->setRating(mt_rand(1, 10));
			$reviews->setReviewTitle($faker->title());
			$reviews->setReviewDescription($faker->paragraph(1, true));
			$reviews->setUpdatedAt($faker->dateTime());
			$manager->persist($reviews);

		}

		$manager->flush();
	}
}
