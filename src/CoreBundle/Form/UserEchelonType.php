<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class UserEchelonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('date', DateType::class, array(
                        'label' => 'Date d\'obtention',
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'form-control datepicker', 'placeholder' => 'Date d\'obtention...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('details', TextareaType::class, array('label' =>'Détails', 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Détails...')))
            
            ->add('echelon', EntityType::class, array('label' => 'Sélectionnez l\'échelon', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Poste & Niveau'), 'class' => 'CoreBundle:Echelon', 'choice_label' => 'designation', 'group_by' => 'poste.name'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\UserEchelon'
        ));
    }
}
