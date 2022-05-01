<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Owner;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class OwnerTest extends KernelTestCase
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

  }

  public function testValidOwner(): void
  {
    $this->assertHasErrors($this->owner, 0);
  }

  //getId
  public function testGetIdOwner()
  {
    $this->assertSame(null, $this->owner->getId());
  }

  //getUserId
  public function testGetUserIdOwner()
  {
    $this->assertSame($this->user, $this->owner->getUserId());
  }
}
