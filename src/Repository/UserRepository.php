<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\ORMException;

/**
 * User repository
 */
class UserRepository extends EntityRepository
{
    /**
     * Create/update user
     *
     * @param User $entity
     * @param bool $flush
     * @return void
     * @throws ORMException
     */
    public function add(User $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
