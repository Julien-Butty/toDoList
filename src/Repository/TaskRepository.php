<?php
/**
 * Created by PhpStorm.
 * User: julienbutty
 * Date: 29/10/2018
 * Time: 06:41.
 */

namespace App\Repository;

use App\Entity\Task;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;

class TaskRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Task::class);
    }

    public function findAllByCached()
    {
        $qb = $this->createQueryBuilder('t')
                ->orderBy('t.id', 'DESC');

        $query = $qb->getQuery();
        $query->useResultCache(true, 3600, 'tasks_all');

        return $query->getResult();
    }

    public function findDoneByCached()
    {
        $qb = $this->createQueryBuilder('t')
            ->where('t.isDone = :isDone')
            ->setParameter('isDone', 1)
            ->orderBy('t.id', 'DESC');

        $query = $qb->getQuery();
        $query->useResultCache(true, 3600, 'tasks_all');

        return $query->getResult();
    }
}
