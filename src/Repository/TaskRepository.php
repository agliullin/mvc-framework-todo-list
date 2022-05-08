<?php

namespace App\Repository;

use App\Entity\Task;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * Task repository
 */
class TaskRepository extends EntityRepository
{
    /**
     * Create/update task
     *
     * @param Task $entity
     * @param bool $flush
     * @return void
     * @throws ORMException
     */
    public function add(Task $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
