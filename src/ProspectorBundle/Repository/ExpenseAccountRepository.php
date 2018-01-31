<?php

namespace ProspectorBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

class ExpenseAccountRepository extends EntityRepository
{
    /**
     * Get all expenses account for the prospector's identity passed in parameter.
     *
     * @param int $id
     * @return mixed
     */
    public function getExpensesAccount($id)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('AppBundle\\Entity\\ExpenseAccount', 'e');
        $rsm->addFieldResult('e', 'id', 'id');
        $rsm->addFieldResult('e', 'month', 'month');
        $rsm->addFieldResult('e', 'night', 'night');
        $rsm->addFieldResult('e', 'middayMeal', 'middayMeal');
        $rsm->addFieldResult('e', 'mileage', 'mileage');
        $rsm->addFieldResult('e', 'totalAmount', 'totalAmount');
        $rsm->addFieldResult('e', 'isSubmit', 'isSubmit');

        return $this->getEntityManager()
            ->createNativeQuery(
                'SELECT expenseAccount.id, month, night, middayMeal, mileage, totalAmount, isSubmit FROM expenseAccount JOIN submit ON submit.expenseAccount_id = expenseAccount.id JOIN person ON person.id = submit.person_id WHERE submit.person_id = :id', $rsm)
            ->setParameter(':id', $id)
            ->getResult();
    }
}
