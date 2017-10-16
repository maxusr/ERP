<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class MatterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom de la matière' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom de la matière...')))
        ->add('coefficient', TextType::class, array('label' => 'Coefficient de la matière' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Coefficient de la matière...')))
        ->add('classrooms', EntityType::class, array('label' => 'Sélectionnez les salles', 'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez les salles...'), 'class' => 'SchoolBundle:Classroom', 'choice_label' => 'name'))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\Matter'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_matter';
    }


}
