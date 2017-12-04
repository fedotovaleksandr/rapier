<?php

namespace AppBundle\Form;

use AppBundle\Entity\EmployeeDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeDayType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Work day
            ->add('day', IntegerType::class)

            // Start time
            ->add('startTime', TimeType::class, [
                'label' => 'label.since',
                'widget' => 'single_text',
            ])

            // End time
            ->add('endTime', TimeType::class, [
                'label' => 'label.till',
                'widget' => 'single_text',
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EmployeeDay::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_employeeday';
    }
}
