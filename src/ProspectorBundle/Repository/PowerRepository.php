<?php

namespace ProspectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class PowerRepository extends EntityRepository
{
    public function getPowerCost($userId)
    {
        return $this->createQueryBuilder('pc')
            ->select('po.cost')
            ->distinct('po.cost')
            ->from('AppBundle:Power', 'po')
            ->join('AppBundle:Profile', 'pr')
            ->join('AppBundle:Car', 'c')
            ->join('AppBundle:Person', 'pe')
            ->where('c.power = po.id')
            ->andWhere('pr.car = c.id')
            ->andWhere('pr.person = :id')
            ->setParameter(':id', $userId)
            ->getQuery()
            ->getResult();
    }
}
