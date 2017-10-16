<?php

namespace CMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class BorrowerType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('firstname', TextType::class, array('required' => false, 'label' => 'Prénom(s)', 'attr' => array('class' => 'form-control')))
            ->add('lastname', TextType::class, array('required' => false, 'label' => 'Nom(s)', 'attr' => array('class' => 'form-control')))
            ->add('telephone', TextType::class, array('required' => false, 'label' => 'Numéro de téléphone', 'attr' => array('class' => 'form-control')))
            ->add('cni', TextType::class, array('required' => false, 'label' => 'CNI', 'attr' => array('class' => 'form-control')))
            ->add('note', TextareaType::class, array('required' => false, 'label' => 'Note', 'attr' => array('class' => 'form-control')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMBundle\Entity\Borrower'
        ));
    }
}
