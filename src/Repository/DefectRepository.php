<?php

namespace App\Repository;

use App\Entity\Defect;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Defect|null find($id, $lockMode = null, $lockVersion = null)
 * @method Defect|null findOneBy(array $criteria, array $orderBy = null)
 * @method Defect[]    findAll()
 * @method Defect[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class DefectRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Defect::class);
    }

    public function get200LastDefects() {
        $qb = $this->createQueryBuilder("d")
            ->orderBy("d.ReportingDate", "DESC")
            ->setMaxResults(200);

        $query = $qb->getQuery();
        return $query->execute();
    }
}
