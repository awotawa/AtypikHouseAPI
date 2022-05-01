<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Owner;
use App\Entity\Category;
use App\Entity\Lodging;
use App\Entity\Media;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MediaTest extends KernelTestCase
{
  use AssertEntityTrait;

  //This will launch before every tests
  public function setUp(): void
  {

    $this->user = (new User())
      ->setFirstName("John")
      ->setLastName("Smith")
      ->setPhoto("https://randomuser.me/api/portraits/men/66.jpg")
      ->setEmail("john.smith@yopmail.com")
      ->setPassword("azertyuiop");
    // ->setCreatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
    // ->setCreatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
    // ->setIsVerified(true)

    $this->owner = (new Owner())
      ->setUserId($this->user);

    $this->category = (new Category())
      ->setType("Châlet");

    $this->lodging = (new Lodging())
      ->setOwnerId($this->owner)
      ->setRate(200)
      ->setLodgingDescription("Petit châlet cosy au sein des Alpes. Vous êtes à deux pas des stations Pouillot-les-Bains et Gigot-Crue. Profitez du grand air de la montagne et passez des moments conviviaux avec ce petit châlet tranquille et rustique.")
      ->setName("Châlet Albert")
      ->setAdress("Annecy, Auvergne-Rhône-Alpe")
      ->setCategoryId($this->category)
      ->setCheckInTime(new DateTime('10:00:00'));

    $this->media = (new Media())
      ->setLink("https://unsplash.com/photos/Yd59eQJVYAo")
      ->setMediaType("Photo")
      ->setLodgingId($this->lodging);
  }

  public function testValidMedia(): void
  {
    $this->assertHasErrors($this->media, 0);
  }

  //getId
  public function testGetIdMedia()
  {
    $this->assertSame(null, $this->media->getId());
  }

  //getLink
  public function testGetLinkMedia()
  {
    $this->assertSame("https://unsplash.com/photos/Yd59eQJVYAo", $this->media->getLink());
  }

  //getMediaType
  public function testGetMediaTypeMedia()
  {
    $this->assertSame("Photo", $this->media->getMediaType());
  }

  //getLodgingId
  public function testGetLodgingIdMedia()
  {
    $this->assertSame($this->lodging, $this->media->getLodgingId());
  }
}
