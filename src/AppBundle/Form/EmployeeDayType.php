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
        $builder->add('employee', EntityType::class, [
            'choice_label' => 'fullName',
            'attr' => ['class' => 'select2_single'],
            'class' => Employee::class,
        ]);

        $builder
            ->add('day', ChoiceType::class, [
                'label' => 'Day of week',
                'choices' => [
                    EmployeeDay::MON,
                    EmployeeDay::TUE,
                    EmployeeDay::WED,
                    EmployeeDay::THU,
                    EmployeeDay::FRI,
                    EmployeeDay::SAT,
                    EmployeeDay::SUN,
                ],
                'constraints' => [new NotBlank()]
            ])
            ->add('startTime', TimeType::class, [
                'label' => 'label.since',
                'widget' => 'single_text',
            ])
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
