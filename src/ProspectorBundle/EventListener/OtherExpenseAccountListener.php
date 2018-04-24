<?php

namespace ProspectorBundle\EventListener;

use Doctrine\ORM\Event\LifecycleEventArgs;
use AppBundle\Entity\OtherExpenseAccount;
use AppBundle\Entity\ExpenseAccount;

class OtherExpenseAccountListener
{
    /**
     * Event launches after OtherExpenseAccount object adds from database.
     *
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postPersist(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof OtherExpenseAccount) {
            return;
        }

        $expenseAccount = $args->getEntityManager()->getRepository(ExpenseAccount::class)
            ->find($entity->getExpenseAccount());

        $expenseAccount->setTotalAmount($expenseAccount->getTotalAmount() + $entity->getAmount());
        $args->getEntityManager()->flush();
    }

    /**
     * Event launches after OtherExpenseAccount object deletes from database.
     *
     * @param LifecycleEventArgs $args
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function postRemove(LifecycleEventArgs $args)
    {
        $entity = $args->getEntity();

        if (!$entity instanceof OtherExpenseAccount) {
            return;
        }

        $expenseAccount = $args->getEntityManager()->getRepository(ExpenseAccount::class)
            ->find($entity->getExpenseAccount());

        $expenseAccount->setTotalAmount($expenseAccount->getTotalAmount() - $entity->getAmount());
        $args->getEntityManager()->flush();
    }
}
