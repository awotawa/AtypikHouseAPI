<?php

namespace App\Tests;

use DateTime;

use App\Entity\LodgingValue;
use App\Entity\Property;
use App\Entity\Lodging;
use App\Entity\Category;
use App\Entity\Owner;
use App\Entity\User;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class LodgingValueTest extends KernelTestCase
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
        ->setType("myType")
        ->setCreatedAt(new DateTime('03/14/2022'))
        ->setUpdatedAt(new DateTime('03/15/2022')); 
    
    $this->lodging = (new Lodging())
        ->setOwnerId($this->owner)
        ->setName("L'Éden")
        ->setRate(59.99)
        ->setLodgingDescription("Lorem ipsum dolor ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur sit amet consectetur")
        ->setAdress("2 rue Verdun, Rosny-sous-Bois, 93110")
        ->setCheckInTime(new \DateTime())
        ->setCategoryId($this->category)
        ->setCreatedAt(new \DateTime('03/14/2022'))
        ->setUpdatedAt(new \DateTime('03/15/2022'));

    $this->property = (new Property())
        ->setCategoryId($this->category)
        ->setNewField("Hauteur Sol")
        ->setDefaultValue("13 mètre")
        ->setCreatedAt(new DateTime('03/14/2022'))
        ->setUpdatedAt(new DateTime('03/15/2022')); 

    $this->lodgingValue = (new LodgingValue())
        ->setPropertyId($this->property)
        ->setLodgingId($this->lodging)
        ->setValue("myValue")
        ->setCreatedAt(new DateTime('03/14/2022'))
        ->setUpdatedAt(new DateTime('03/15/2022')); 

  }

  public function testValidLodgingValue(): void
  {
    $this->assertHasErrors($this->lodgingValue, 0);
  }


  //ID TESTING
  // GET id
  public function testGetIdLodgingValue()
  {
    $this->assertSame(null, $this->lodgingValue->getId());
  }



  //FOREIGN ID TESTING
  // GET property_id
  public function testGetPropertyIdLodgingValue()
  {
    $this->assertSame($this->property, $this->lodgingValue->getPropertyId());
  }

  // GET lodging_id
  public function testGetLodgingIdLodgingValue()
  {
    $this->assertSame($this->lodging, $this->lodgingValue->getLodgingId());
  }



  //VALUE TESTING
  // SET Too long value
  public function testValueTooLongLodgingValue(): void
  {
    $this->assertHasErrors($this->lodgingValue->setValue("aaaaaaaaaaa"), 1, 'value', 'Your value cannot be longer than 10 characters');
  }

  // Invalid characters value
  public function testValueWrongCharacterLodgingValue(): void
  {
    $this->assertHasErrors($this->lodgingValue->setValue("aé a>>"), 1, 'value', 'This value is not valid.');
  }

  // GET value
  public function testGetValueLodgingValue()
  {
    $this->assertSame("myValue", $this->lodgingValue->getValue());
  }

    



  //getCreatedAt
  public function testGetCreatedAtLodgingValue()
  {
    $this->assertEquals(new DateTime('03/14/2022'), $this->lodgingValue->getCreatedAt());
  }

  //getUpdatedAt
  public function testGetUpdatedAtLodgingValue()
  {
    $this->assertEquals(new DateTime('03/15/2022'), $this->lodgingValue->getUpdatedAt());
  }


}
