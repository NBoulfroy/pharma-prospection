<?php

namespace ProspectorBundle\Form;

use AppBundle\Entity\ExpenseAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ExpenseAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('night', NumberType::class, array('label' => 'Night(s):'))
            ->add('middayMeal', NumberType::class, array('label' => 'Midday meal(s):'))
            ->add('mileage', NumberType::class, array('label' => 'Mileages:'))
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
