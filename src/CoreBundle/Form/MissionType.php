<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class MissionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom de la mission...')))
            ->add('description', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Description...')))
            ->add('place', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lieu de la mission...')))
            ->add('duration', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Durée de la mission...')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Mission'
        ));
    }
}
