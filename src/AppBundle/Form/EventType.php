<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\EmployeeDay;
use AppBundle\Entity\Event;
use AppBundle\Entity\Role;
use AppBundle\Entity\Schedule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EventType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Title & description
            ->add('title', null, ['label' => 'label.title'])
            ->add('description', null, ['label' => 'label.description'])

            // Start date
            ->add('startDate', DateTimeType::class, [
                'label' => 'label.start_date',
                'widget' => 'single_text',
            ])

            // Duration & importance
            ->add('duration', IntegerType::class)
            ->add('importance', ChoiceType::class, [
                'event.wt.minor' => Event::WT_MINOR,
                'event.wt.medium' => Event::WT_MEDIUM,
                'event.wt.major' => Event::WT_MAJOR,
                'event.wt.critical' => Event::WT_CRITICAL,
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
                'disabled' => true,
            ])

            // Responsible employee
            ->add('employee', EntityType::class, [
                'label' => 'label.responsible',
                'class' => Employee::class,
                // TODO choices
                'choices' => [],
            ])

            // Schedule
            ->add('schedule', EntityType::class, [
                'label' => 'label.schedule',
                'choice_label' => 'title',
                'class' => Schedule::class,
            ])

            // Days of performing
            // TODO add transformer
            ->add('onDays', ChoiceType::class, [
                'label' => 'label.event_days',
                'choices' => [
                    'week.mon' => EmployeeDay::MON,
                    'week.tue' => EmployeeDay::TUE,
                    'week.wed' => EmployeeDay::WED,
                    'week.thu' => EmployeeDay::THU,
                    'week.fri' => EmployeeDay::FRI,
                    'week.sat' => EmployeeDay::SAT,
                    'week.sun' => EmployeeDay::SUN,
                ],
                'expanded' => true,
                'multiple' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
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
