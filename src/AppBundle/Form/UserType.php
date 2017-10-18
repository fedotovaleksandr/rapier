<?php

namespace AppBundle\Form;

use AppBundle\Entity\Employee;
use AppBundle\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('employee', EntityType::class, [
            'choice_name' => 'fullName',
            'attr' => ['class' => 'select2_single'],
            'class' => Employee::class
        ]);

        $builder->add('roles', ChoiceType::class, [
            'choices' => array_combine(User::getAvailableRoles(),User::getAvailableRoles()),
            'choices_as_values' => true,
            'attr' => ['class' => 'select2_multiple '],
            'multiple' => true
        ]);

        $builder->add('email', EmailType::class);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'AppBundle\Entity\User'
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_user';
    }


}
