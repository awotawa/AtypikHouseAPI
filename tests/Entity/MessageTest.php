<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Entity\Owner;
use App\Entity\Message;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class MessageTest extends KernelTestCase
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

    $this->user2 = (new User())
      ->setFirstName("Billy")
      ->setLastName("Smith")
      ->setPhoto("https://randomuser.me/api/portraits/men/60.jpg")
      ->setEmail("billy.smith@yopmail.com")
      ->setPassword("azertyuiop");
    // ->setCreatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
    // ->setUpdatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
    // ->setIsVerified(true)

    $this->owner = (new Owner())
      ->setUserId($this->user);

    $this->message = (new Message())
      ->setUserId($this->user2)
      ->setOwnerId($this->owner)
      ->setMessageContent("This is a sample message.")
      ->setCreatedAt(new DateTime('03/13/2022'))
      ->setUpdatedAt(new DateTime('03/13/2022'));
  }

  public function testValidMessage(): void
  {
    $this->assertHasErrors($this->message, 0);
  }

  //getId
  public function testGetIdMessage()
  {
    $this->assertSame(null, $this->message->getId());
  }

  //getMessageContent
  public function testGetMessageContentMessage()
  {
    $this->assertSame("This is a sample message.", $this->message->getMessageContent());
  }

  //getCreatedAt
  public function testGetCreatedAtMessage()
  {
    $this->assertEquals(new DateTime('03/13/2022'), $this->message->getCreatedAt());
  }

  //setCreatedAt
  //getUpdatedAt
  public function testGetUpdatedAtMessage()
  {
    $this->assertEquals(new DateTime('03/13/2022'), $this->message->getUpdatedAt());
  }

  //setUpdatedAt
  //getUserId
  public function testGetUserIdMessage()
  {
    $this->assertSame($this->user2, $this->message->getUserId());
  }

  //getOwnerId
  public function testGetOwnerIdMessage()
  {
    $this->assertSame($this->owner, $this->message->getOwnerId());
  }

}
