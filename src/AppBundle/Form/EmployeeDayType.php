<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeDay;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmployeeDayType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('day', ChoiceType::class, [
                'label' => 'Day of week',
                'choices' => array_flip(EmployeeDay::DAY_TITLES),
                'constraints' => [new NotBlank()]
            ])
            ->add('startTime', TimeType::class, [
                'label' => 'label.since',
                'widget' => 'single_text',
                'empty_data' => '08:00',
                'placeholder' => '08:00',
            ])
            ->add('endTime', TimeType::class, [
                'label' => 'label.till',
                'widget' => 'single_text',
                'empty_data' => '18:00',
                'placeholder' => '18:00',
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
