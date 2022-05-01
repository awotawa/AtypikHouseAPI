<?php

namespace App\Tests;

use DateTime;

use App\Entity\Review;
use App\Entity\Category;
use App\Entity\Lodging;
use App\Entity\Owner;
use App\Entity\User;
use App\Tests\Entity\tools\AssertEntityTrait;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ReviewTest extends KernelTestCase
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
        ->setType("myType01")
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

    $this->review = (new Review())
        ->setOwnerId($this->owner)
        ->setLodgingId($this->lodging)
        ->setUserId($this->user)
        ->setRating(9)
        ->setReviewTitle("My rewiew title !")
        ->setReviewDescription("Lorem ipsum dolor ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur ipsum dolor sit amet consectetur sit amet consectetur")
        ->setCreatedAt(new DateTime('03/14/2022'))
        ->setUpdatedAt(new DateTime('03/15/2022'));

  }

  public function testValidReview(): void
  {
    $this->assertHasErrors($this->review, 0);
  }


  //ID TESTING
  // GET id
  public function testGetIdReview()
  {
    $this->assertSame(null, $this->review->getId());
  }




  //FOREIGN ID TESTING
  // GET owner_id
  public function testGetOwnerIdReview()
  {
    $this->assertSame($this->owner, $this->review->getOwnerId());
  }

  // GET lodging_id
  public function testGetLodgingIdReview()
  {
    $this->assertSame($this->lodging, $this->review->getLodgingId());
  }

  // GET user_id
  public function testGetUserIdReview()
  {
    $this->assertSame($this->user, $this->review->getUserId());
  }
  


  //RATING TESTING  
  // SET Too short rating ( Rate < 1 ) 
  public function testRatingTooShortReview(): void
  {
    $this->assertHasErrors($this->review->setRating(-2), 2, 'rating', 'This value should be between 1 and 10.');
    $this->assertHasErrors($this->review->setRating(-2), 2, 'rating', 'This value is not valid.');
  }

  // SET Too high rating ( Rate > 10 )
  public function testRatingTooHighReview(): void
  {
    $this->assertHasErrors($this->review->setRating(11), 2, 'rating', 'This value should be between 1 and 10.');
    $this->assertHasErrors($this->review->setRating(11), 2, 'rating', 'This value is not valid.');
  }

  // GET rating
  public function testGetRatingReview()
  {
    $this->assertSame(9, $this->review->getRating());
  }




  //REVIEW TITLE TESTING
  // SET Too high review_title
  public function testTitleTooLongReview(): void
  {
    $this->assertHasErrors($this->review->setReviewTitle("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"), 1, 'review_title', 'Your review title cannot be longer than 100 characters');
  }

  // Invalid characters review_title
  public function testTitleWrongCharacterReview(): void
  {
    $this->assertHasErrors($this->review->setReviewTitle("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa>>"), 1, 'review_title', 'This value is not valid.');
  }

  // GET review_title
  public function testGetTitleReview()
  {
    $this->assertSame("My rewiew title !", $this->review->getReviewTitle());
  }



  //REVIEW DESCRIPTION TESTING
  // SET Too long review_description
  public function testDescriptionTooLongReview(): void
  {
    $this->assertHasErrors($this->review->setReviewDescription("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa"), 1, 'review_description', 'Your review description cannot be longer than 255 characters');
  }

  // Invalid characters review_description
  public function testDescriptionWrongCharacterReview(): void
  {
    $this->assertHasErrors($this->review->setReviewDescription("aaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaaa>>"), 1, 'review_description', 'This value is not valid.');
  }

  // GET review_description
  public function testGetDescriptionReview()
  {
    $this->assertSame("My rewiew title !", $this->review->getReviewTitle());
  }

   
  

  //getCreatedAt
  public function testGetCreatedAtReview()
  {
    $this->assertEquals(new DateTime('03/14/2022'), $this->review->getCreatedAt());
  }

  //getUpdatedAt
  public function testGetUpdatedAtReview()
  {
    $this->assertEquals(new DateTime('03/15/2022'), $this->review->getUpdatedAt());
  }


}
