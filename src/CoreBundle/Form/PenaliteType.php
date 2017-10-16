<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

class PenaliteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duration', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Durée de la pénalité...')))
            ->add('motif', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Motif ...')))
            ->add('date', DateType::class, array(
                        'label' => 'Date de la pénalité',
                        'required' => true,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de la pénalité...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Penalite'
        ));
    }
}
