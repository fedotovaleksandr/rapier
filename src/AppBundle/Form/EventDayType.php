<?php
/**
 * Created by PhpStorm.
 * User: afedotov
 * Date: 21.03.18
 * Time: 22:52.
 */

namespace AppBundle\Form;

use AppBundle\Entity\EmployeeDay;
use AppBundle\Entity\EventDay;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class EventDayType extends AbstractType
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
                'constraints' => [new NotBlank()],
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EventDay::class,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_eventeday';
    }
}
