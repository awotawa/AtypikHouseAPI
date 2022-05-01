<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Owner;
use App\Entity\Category;
use App\Entity\Lodging;
use App\Entity\Reservation;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReservationTest extends KernelTestCase
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

    $this->reservation = (new Reservation())
      ->setUserId($this->user)
      ->setLodgingId($this->lodging)
      ->setPrice(600)
      ->setStartDate(new DateTime('03/13/2022'))
      ->setEndDate(new DateTime('03/16/2022'))
      ->setPaid(true)
      ->setCreatedAt(new DateTime('03/13/2022'))
      ->setUpdatedAt(new DateTime('03/13/2022'));
  }

  public function testValidReservation(): void
  {
    $this->assertHasErrors($this->reservation, 0);
  }

  //getId
  public function testGetIdReservation()
  {
    $this->assertSame(null, $this->reservation->getId());
  }

  //getPrice
  public function testGetPriceMessage()
  {
    $this->assertSame(600.0, $this->reservation->getPrice());
  }

  //setPrice
  //getStartDate
  //setStartDate
  public function testGetStartDateReservation()
  {
    $this->assertEquals(new DateTime('03/13/2022'), $this->reservation->getStartDate());
  }

  //getEndDate
  public function testGetEndDateReservation()
  {
    $this->assertEquals(new DateTime('03/16/2022'), $this->reservation->getEndDate());
  }

  //setEndDate
  //getPaid
  public function testGetPaidReservation()
  {
    $this->assertSame(true, $this->reservation->getPaid());
  }

  //setPaid
  //getCreatedAt
  public function testGetCreatedAtReservation()
  {
    $this->assertEquals(new DateTime('03/13/2022'), $this->reservation->getCreatedAt());
  }

  //setCreatedAt
  //getUpdatedAt
  public function testGetUpdatedAtReservation()
  {
    $this->assertEquals(new DateTime('03/13/2022'), $this->reservation->getUpdatedAt());
  }
  //setCreatedAt
  //getUpdatedAt
  //setUpdatedAt
  //getUserId
  public function testGetUserIdReservation()
  {
    $this->assertSame($this->user, $this->reservation->getUserId());
  }

  //setUserId
  //getLodgingId
  public function testGetLodgingIdReservation()
  {
    $this->assertSame($this->lodging, $this->reservation->getLodgingId());
  }

  //setLodgingId

}
