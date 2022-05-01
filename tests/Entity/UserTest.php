<?php

namespace App\Tests;

use DateTime;
use App\Entity\User;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class UserTest extends KernelTestCase
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
      ->setPassword("Azerty123.")
      ->setRoles(['ROLE_USER']);
      // ->setCreatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
      // ->setCreatedAt(new \DateTime('2005-08-15T15:52:01+00:00'))
      // ->setIsVerified(true)

  }

  public function testValidUser(): void
  {
    $this->assertHasErrors($this->user, 0);
  }

  //ID TESTING
  // Get id
  public function testGetIdUser()
  {
    $this->assertSame(null, $this->user->getId());
  }

  //FIRST_NAME TESTING
  // Blank first_name
  public function testFirstNameBlankUser(): void
  {
    $this->assertHasErrors($this->user->setFirstName(""), 2, 'first_name', 'This value should not be blank.');
    $this->assertHasErrors($this->user->setFirstName(""), 2, 'first_name', 'Your first name must be at least 2 characters long');
  }

  // Wrong type first_name
  public function testFirstNameWrongTypeUser(): void
  {
    $this->assertHasErrors($this->user->setFirstName(42), 1, 'first_name', 'This value is not valid.');
  }

  // Too short first_name
  public function testFirstNameTooShortUser(): void
  {
    $this->assertHasErrors($this->user->setFirstName("A"), 1, 'first_name', 'Your first name must be at least 2 characters long');
  }

  // Too long first_name
  public function testFirstNameTooLongUser(): void
  {
    $this->assertHasErrors($this->user->setFirstName("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaAAAAAA"), 1, 'first_name', 'Your first name cannot be longer than 255 characters');
  }

  // Invalid characters first_name
  public function testFirstNameWrongCharacterUser(): void
  {
    $this->assertHasErrors($this->user->setFirstName("X-Tr3M?!"), 1, 'first_name', 'This value is not valid.');
  }
  // Get first_name
  public function testGetFirstNameUser()
  {
    $this->assertSame("John", $this->user->getFirstName());
  }

  //LAST_NAME TESTING
  // Blank first_name
  public function testLastNameBlankUser(): void
  {
    $this->assertHasErrors($this->user->setlastName(""), 2, 'last_name', 'This value should not be blank.');
    $this->assertHasErrors($this->user->setlastName(""), 2, 'last_name', 'Your last name must be at least 2 characters long');
  }

  // Wrong type last_name
  public function testLastNameWrongTypeUser(): void
  {
    $this->assertHasErrors($this->user->setlastName(42), 1, 'last_name', 'This value is not valid.');
  }

  // Too short last_name
  public function testLastNameTooShortUser(): void
  {
    $this->assertHasErrors($this->user->setlastName("A"), 1, 'last_name', 'Your last name must be at least 2 characters long');
  }

  // Too long last_name
  public function testLastNameTooLongUser(): void
  {
    $this->assertHasErrors($this->user->setlastName("bbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbbBBBBBB"), 1, 'last_name', 'Your last name cannot be longer than 255 characters');
  }

  // Invalid characters last_name
  public function testLastNameWrongCharacterUser(): void
  {
    $this->assertHasErrors($this->user->setlastName("Sp0rtzz-420?!"), 1, 'last_name', 'This value is not valid.');
  }
  // Get last_name
  public function testGetLastNameUser()
  {
    $this->assertSame("Smith", $this->user->getLastName());
  }

  //EMAIL TESTING
  // Blank email
  public function testEmailBlankUser(): void
  {
    $this->assertHasErrors($this->user->setEmail(""), 1, 'email', 'This value should not be blank.');
  }
  // Wrong pattern email
  public function testEmailWrongPatternUser(): void
  {
    $this->assertHasErrors($this->user->setEmail("bad@email..com"), 1, 'email', 'This value is not valid.');
  }
  // Get email
  public function testGetEmailUser()
  {
    $this->assertSame("john.smith@yopmail.com", $this->user->getEmail());
  }

  //PASSWORD TESTING
  // Blank password
  public function testPasswordBlankUser(): void
  {
    $this->assertHasErrors($this->user->setPassword(""), 2, 'password', 'This value should not be blank.');
    $this->assertHasErrors($this->user->setPassword(""), 2, 'password', 'Your password must be at least 8 characters long');
  }
  // Too short password
  public function testPasswordTooShortUser(): void
  {
    $this->assertHasErrors($this->user->setPassword("Sd86!"), 2, 'password', 'This value is not valid.');
    $this->assertHasErrors($this->user->setPassword("sd"), 2, 'password', 'Your password must be at least 8 characters long');
  }

  // Invalid format password
  public function testPasswordInvalidFormatUser(): void
  {
    $this->assertHasErrors($this->user->setPassword("Sdssssss<"), 1, 'password', 'This value is not valid.');
  }
  
  //PHOTO TESTING
  // No photo
  public function testPhotoBlankUser(): void
  {
    $this->assertHasErrors($this->user->setPhoto(""), 0);
  }
  // Wrong format photo
  public function testPhotoWrongFormatUser(): void
  {
    $this->assertHasErrors($this->user->setPhoto("https://wrongpattern"), 1, 'photo', 'This value is not valid.');
  }
  // Get photo
  public function testGetPhotoUser()
  {
    $this->assertSame("https://randomuser.me/api/portraits/men/66.jpg", $this->user->getPhoto());
  }

  // getUserIdentifier
  public function testGetUserIdentifierUser()
  {
    $this->assertSame("john.smith@yopmail.com", $this->user->getUserIdentifier());
  }

  //getRoles
  public function testGetRolesUser()
  {
    $this->assertSame(['ROLE_USER'], $this->user->getRoles());
  }

  //getPassword
  public function testGetPasswordUser()
  {
    $this->assertSame('Azerty123.', $this->user->getPassword());
  }
}
