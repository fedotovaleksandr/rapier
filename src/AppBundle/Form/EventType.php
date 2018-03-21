<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeDay;
use AppBundle\Entity\Event;
use AppBundle\Entity\Role;
use AppBundle\Entity\Schedule;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        /** @var EntityManager $em */
        $em  = $options['em'];
        $builder
            // Title & description
            ->add('title', null, ['label' => 'label.title'])
            ->add('description', null, ['label' => 'label.description'])
            // Start date
            ->add('startDate', DateTimeType::class, [
                'label' => 'label.start_date',
            ])
            // Duration & importance
            ->add('duration', IntegerType::class)
            ->add('importance', ChoiceType::class, [
                'choices' => [
                    'event.wt.minor' => Event::WT_MINOR,
                    'event.wt.medium' => Event::WT_MEDIUM,
                    'event.wt.major' => Event::WT_MAJOR,
                    'event.wt.critical' => Event::WT_CRITICAL,
                ],
                'constraints' => [
                    new NotBlank()
                ]
            ])
            ->add('period', ChoiceType::class, [
                'choices' => array_flip(Event::PERIOD_TITLES),
                'constraints' => [
                    new NotBlank()
                ]
            ])
            // Status
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'event.status.draft' => Event::STATUS_DRAFT,
                    'event.status.open' => Event::STATUS_OPEN,
                    'event.status.work' => Event::STATUS_WORK,
                    'event.status.finish' => Event::STATUS_FINISH,
                    'event.status.closed' => Event::STATUS_CLOSED,
                ],
            ])
            // Responsible role
            ->add('role', EntityType::class, [
                'label' => 'label.role',
                'class' => Role::class,
            ])
            ->add('owner', EntityType::class, [
                'label' => 'label.owner',
                'class' => Employee::class,
                'data' => $em->getReference(Employee::class,$options['owner']->getId()),
                //'attr' => ['disabled' => 'true'],
                'query_builder' => function (EntityRepository $repository) use ($options) {
                    $qb = $repository->createQueryBuilder('e')
                        ->where('e.id = :id')
                        ->setParameter('id', $options['owner']->getId());

                    return $qb;
                },
            ])
            // Responsible employee
            ->add('employee', EntityType::class, [
                'label' => 'label.responsible',
                'class' => Employee::class,
            ])
            // Schedule
            ->add('schedule', EntityType::class, [
                'label' => 'label.schedule',
                'choice_label' => 'title',
                'class' => Schedule::class,
            ])
            // Days of performing
            ->add('eventDays', CollectionType::class, [
                'label' => 'label.event_days',
                'entry_type' => EventDayType::class,
                'allow_add' => true,
                'allow_delete' => true,
                'entry_options' => ['label'=>false],
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
        $resolver->setRequired(['owner','em']);
        $resolver->setAllowedTypes('owner',Employee::class);
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_event';
    }
}
