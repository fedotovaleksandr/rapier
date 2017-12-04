<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Name & e-mail
            ->add('lastName', null, ['label' => 'label.lastname'])
            ->add('firstName', null, ['label' => 'label.firstname'])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'property_path' => 'user.email',
            ])

            // Gender
            ->add('gender', ChoiceType::class, [
                'label' => 'label.gender',
                'choices' => [
                    'gender.male' => 'M',
                    'gender.female' => 'F',
                ],
            ])

            // Phone & manager
            ->add('phone', null, ['label' => 'label.phone'])
            ->add('manager', EntityType::class, [
                'label' => 'label.manager',
                'class' => Employee::class,
                // TODO choices
                'choices' => [],
            ])

            // Roles
            ->add('roles', EntityType::class, [
                'label' => 'label.roles',
                'class' => Role::class,
                'multiple' => true,
            ])

            // Work mode
            ->add('workMode', ChoiceType::class, [
                'label' => 'label.workmode',
                'choices' => [
                    'workmode.default' => Employee::WORKMODE_DEFAULT,
                    'workmode.custom' => Employee::WORKMODE_CUSTOM,
                ],
            ])

            // Work days
            ->add('employeeDays', CollectionType::class, [
                'label' => 'label.employee_days',
                'entry_type' => EmployeeDayType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver
            ->setDefaults([
                'data_class' => Employee::class,
            ]);
        /*->setRequired([
            'employee_manager'
        ]);*/
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_employee';
    }
}
