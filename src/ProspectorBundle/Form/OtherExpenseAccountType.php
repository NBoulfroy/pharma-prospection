<?php

namespace ProspectorBundle\Form;

use AppBundle\Entity\OtherExpenseAccount;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OtherExpenseAccountType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('designation', TextType::class, array('label' => 'Designation:'))
            ->add('amount', NumberType::class, array('label' => 'Amount:'))
            ->add('file', FileType::class, array('label' => 'File:'))
            ->getForm()
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => OtherExpenseAccount::class,
        ));
    }
}
