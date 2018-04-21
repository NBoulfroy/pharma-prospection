<?php

namespace ProspectorBundle\Form;

use AppBundle\Entity\ExpenseAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseAccountSubmitType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('expenseAccountId', HiddenType::class)
            ->add('submit', SubmitType::class)
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => ExpenseAccount::class,
        ));
    }
}
