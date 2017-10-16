<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class BookType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom du document' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom du document...')))
        ->add('reference', TextType::class, array('label' => 'Reférence/Numéro' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Reférence/Numéro...')))
        ->add('order', TextType::class, array('label' => 'Ordre' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Ordre...')))
        ->add('author', TextType::class, array('label' => 'Auteur du document' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Auteur du document...')))
        ->add('year', TextType::class, array('label' => 'Année du document' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Année de parution...')))
        ->add('quantity', TextType::class, array('label' => 'Quantité' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Quantité...')))
        ->add('activity', TextType::class, array('label' => 'Activité' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Activité...')))
        ->add('observation', TextareaType::class, array('label' => 'Observation' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Observation...')))
        ->add('available', CheckboxType::class, array('label' => 'Document disponible' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Document disponible...')))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\Book'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_book';
    }


}
