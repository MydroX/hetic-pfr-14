<?php

namespace App\Repository;

use App\Entity\EventPlace;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method EventPlace|null find($id, $lockMode = null, $lockVersion = null)
 * @method EventPlace|null findOneBy(array $criteria, array $orderBy = null)
 * @method EventPlace[]    findAll()
 * @method EventPlace[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventPlaceRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, EventPlace::class);
    }

}
