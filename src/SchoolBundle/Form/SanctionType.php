<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;


use SchoolBundle\Entity\Sanction;

class SanctionType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('type', ChoiceType::class, array('label' =>'Type', 'required' => true, 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Type de sanction...'), 'choices' => Sanction::TYPES))
        ->add('description', TextareaType::class, array('label' => 'Description' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Description...')))
        ->add('madeAt', DateType::class, array(
                        'label' => 'Fait le',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Fait le...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ->add('duration', TextType::class, array('label' => 'Durée (Jours)' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Durée(Jours)...')))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\Sanction'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_sanction';
    }


}
