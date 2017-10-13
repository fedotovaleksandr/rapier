<?php

namespace AppBundle\Form;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EmployeeType extends AbstractType
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('lastName')
            ->add('firstName')
            ->add('gender', ChoiceType::class, array(
                'choices' => array(
                    'gender.male' => 'M',
                    'gender.female' => 'F',
                ),
            ))
            ->add('phone')
            ->add('manager') // TODO manager selection
            ->add('roles', CollectionType::class, array(
                'entry_type' => RoleType::class,
                'allow_add' => true,
            ))
            ->add('workMode', ChoiceType::class, array(
                'choices' => array(
                    'workmode.default' => $this->getParameter('rapier.work_modes')['default'],
                    'workmode.custom' => $this->getParameter('rapier.work_modes')['custom'],
                ),
            ));
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Employee',
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_employee';
    }

    private function getParameter(string $id)
    {
        return $this->container->getParameter($id);
    }
}
