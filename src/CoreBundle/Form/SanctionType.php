<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use CoreBundle\Entity\Sanction;

class SanctionType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('type', ChoiceType::class, array('label' =>'Type', 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Type...'), 'choices' => Sanction::TYPES))
            ->add('debut', DateType::class, array(
                        'label' => 'Date de debut',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de debut...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('fin', DateType::class, array(
                        'label' => 'Date de fin',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de fin...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('content', TextareaType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Détails de sanction...')))
            ->add('title', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Titre...')))

        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Sanction'
        ));
    }
}
