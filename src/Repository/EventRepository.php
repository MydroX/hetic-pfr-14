<?php

namespace App\Repository;

use App\Entity\Event;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Event::class);
    }

    public function findEventsOrderByDate() {
        return $this->createQueryBuilder('e')
            ->orderBy("e.date")
            ->getQuery()
            ->getResult()
        ;
    }

    public function findEventsByDateId($dateId)
    {
        return $this->createQueryBuilder('e')
            ->where('e.dateId = :dateId')
            ->andWhere('e.sportId = :sportId')
            ->setParameter('dateId', $dateId)
            ->getQuery()
            ->getResult();
    }


    public function findCountForEveryDate($district)
    {
        $conn = $this->getEntityManager()->getConnection();

        $sql = "SELECT COUNT(`event`.`id`) AS `events` , `event`.`date_id` 
                FROM `event_place` 
                LEFT JOIN `sport` ON `event_place`.`id` = `sport`.`place_id`
                LEFT JOIN `event` ON `sport`.`id` = `event`.`sport_id`
                WHERE `event_place`.`district` = :district AND `event`.`id` IS NOT NULL 
                GROUP BY `event`.`date_id`
                ORDER BY `event`.`date_id` ASC"
        ;

        $stmt = $conn->prepare($sql);
        $stmt->execute(['district' => $district]);

        return $stmt->fetchAll();
    }
}
