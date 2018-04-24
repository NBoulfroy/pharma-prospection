<?php

namespace ProspectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ParameterRepository extends EntityRepository
{
    /**
     * Returns the value flat rate.
     *
     * @param string $designation
     * @return mixed
     */
    public function getPrice($designation)
    {
        return $this->getEntityManager()->createQuery('SELECT p.value FROM AppBundle:Parameter p WHERE p.designation = :designation')
            ->setParameter(':designation', $designation)
            ->getResult();
    }
}
