<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\DataPersisterInterface;
use App\Entity\Property;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class PropertyPersister implements DataPersisterInterface
{
  protected $em;

  public function __construct(EntityManagerInterface $em)
  {
    $this->em = $em;
  }

  public function supports($data): bool
  {
    return $data instanceof Property;
  }

  public function persist($data): void
  {
    // 1. Mettre une date de création sur le lodging
    // $data->setCreatedAt(new \DateTime());
    // 2. Mettre une date de update sur le lodging
    $data->setUpdatedAt(new \DateTime());
    // 3. Ask Doctrine to persist the data
    $this->em->persist($data);
    // 4. Send data to the DB
    $this->em->flush();
  }

  public function remove($data): void
  {
    // 1. Demander à doctrine de supprimer le lodging
    $this->em->remove($data);
    $this->em->flush();
  }
}
