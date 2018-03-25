<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\Role;
use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EmployeeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var Employee $currentEmployee */
        $currentEmployee = $options['data'];
        $builder
            // Name & e-mail
            ->add('lastName', null, ['label' => 'label.lastname'])
            ->add('firstName', null, ['label' => 'label.firstname'])
            ->add('email', EmailType::class, [
                'label' => 'label.email',
                'property_path' => 'email',
            ])
            // Gender
            ->add('gender', ChoiceType::class, [
                'label' => 'label.gender',
                'attr' => ['class' => 'select2_single'],
                'choices' => [
                    'gender.male' => 'M',
                    'gender.female' => 'F',
                ],
            ])
            // Phone & manager
            ->add('phone', TelType::class, ['label' => 'label.phone'])
            ->add('manager', EntityType::class, [
                'label' => 'label.manager',
                'class' => Employee::class,
                'attr' => ['class' => 'select2_single'],
                'query_builder' => function (EntityRepository $repository) use ($currentEmployee) {
                    $qb = $repository->createQueryBuilder('e')
                        ->leftJoin('e.user', 'u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role',
                            sprintf('%%"%s"%%', User::ROLE_MANAGER)
                        );
                    if ($currentEmployee->getId()) {
                        $qb->andWhere('e.id != :curId')
                            ->setParameter('curId', $currentEmployee->getId());
                    }

                    return $qb;
                },
            ])
            // Roles
            ->add('roles', EntityType::class, [
                'label' => 'label.roles',
                'class' => Role::class,
                'attr' => ['class' => 'select2_multiple'],
                'multiple' => true,
            ])
            ->add('user', EntityType::class, [
                'label' => 'Choose User',
                'class' => User::class,
                'attr' => ['class' => 'select2_single'],
                'query_builder' => function (EntityRepository $repository) use ($currentEmployee) {
                    $qb = $repository->createQueryBuilder('u')
                        ->leftJoin('u.employee', 'e')
                        ->where('e is NULL');
                    if ($currentEmployee->getUser()) {
                        $qb->orWhere('u.id != :curId')
                            ->setParameter('curId', $currentEmployee->getUser()->getId());
                    }

                    return $qb;
                },
                'constraints' => [
                    new NotBlank(),
                ],
            ])
            // Work mode
            ->add('workMode', ChoiceType::class, [
                'label' => 'label.workmode',
                'attr' => ['class' => 'select2_single'],
                'choices' => [
                    'workmode.default' => Employee::WORKMODE_DEFAULT,
                    'workmode.custom' => Employee::WORKMODE_CUSTOM,
                ],
            ])
            // Work days
            ->add('employeeDays', CollectionType::class, [
                'label' => 'label.employee_days',
                'entry_type' => EmployeeDayType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => ['label' => false],
                'prototype' => true,
                'by_reference' => false,
                'attr' => ['class' => 'collection-type'],
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
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_employee';
    }
}
