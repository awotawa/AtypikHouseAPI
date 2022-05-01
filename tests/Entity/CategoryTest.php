<?php

namespace App\Tests;

use DateTime;

use App\Entity\Category;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryTest extends KernelTestCase
{
  use AssertEntityTrait;

  //This will launch before every tests
  public function setUp(): void
  {

    $this->category = (new Category())
        ->setType("myType")
        ->setCreatedAt(new DateTime('03/14/2022'))
        ->setUpdatedAt(new DateTime('03/15/2022')); 

  }

  public function testValidCategory(): void
  {
    $this->assertHasErrors($this->category, 0);
  }


  //ID TESTING
  // GET id
  public function testGetIdReview()
  {
    $this->assertSame(null, $this->category->getId());
  }




  //TYPE TESTING
  // SET Too long type
  public function testTypeTooLongCategory(): void
  {
    $this->assertHasErrors($this->category->setType("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"), 1, 'type', 'Your type cannot be longer than 30 characters');
  }

  // Invalid characters type
  public function testTypeWrongCharacterCategory(): void
  {
    $this->assertHasErrors($this->category->setType("aaaaaaa>>"), 1, 'type', 'This value is not valid.');
  }

  // GET type
  public function testGetTypeCategory()
  {
    $this->assertSame("myType", $this->category->getType());
  }




  //getCreatedAt
  public function testGetCreatedAtCategory()
  {
    $this->assertEquals(new DateTime('03/14/2022'), $this->category->getCreatedAt());
  }

  //getUpdatedAt
  public function testGetUpdatedAtCategory()
  {
    $this->assertEquals(new DateTime('03/15/2022'), $this->category->getUpdatedAt());
  }


}
