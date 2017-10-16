<?php

namespace CMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ProductType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
            ->add('reference', TextType::class, array('required' => false, 'label' => 'Référence', 'attr' => array('class' => 'form-control')))
            ->add('quantity', NumberType::class, array('label' => 'Quantité', 'attr' => array('class' => 'form-control')))
            ->add('description', TextareaType::class, array('required' => false, 'label' => 'Description', 'attr' => array('class' => 'form-control')))
            ->add('category', EntityType::class, array('label' => 'Sélectionnez la catégorie', 'class' => 'CMBundle:Category', 'choice_label' => 'name', 'attr' => array('class' => 'form-control')))
            ->add('isConsommable', CheckboxType::class, array('label' => 'Ce produit est un consommable?', 'required' => false, 'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMBundle\Entity\Product'
        ));
    }
}
