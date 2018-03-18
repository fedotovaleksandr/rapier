<?php

namespace AppBundle\Form;

use AppBundle\Entity\Event;
use AppBundle\Entity\Schedule;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ScheduleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // Title & description
            ->add('title', null, ['label' => 'label.title'])
            ->add('description', TextareaType::class, ['label' => 'label.description'])
            // Start date
            ->add('startDate', DateType::class, [
                'label' => 'label.start_date',
                'widget' => 'single_text',
            ])
            // End date
            ->add('endDate', DateType::class, [
                'label' => 'label.end_date',
                'widget' => 'single_text',
            ])
            ->add('events', EntityType::class, [
                'label'=>'Events',
                'choice_label' => 'getTitle',
                'attr' => ['class' => 'select2_multiple'],
                'class' => Event::class,
                'multiple' => true,
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Schedule::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_schedule';
    }
}
