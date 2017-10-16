<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ExamType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom de l\'examen' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom de l\'examen...')))
        ->add('startDate', DateType::class, array(
                        'label' => 'Date de debut',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de debut...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ->add('endDate', DateType::class, array(
                        'label' => 'Date de fin',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de fin...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ->add('classrooms', EntityType::class, array('label' => 'Sélectionnez les salles', 'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez les salles...'), 'class' => 'SchoolBundle:Classroom', 'choice_label' => 'name'))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\Exam'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_exam';
    }


}
