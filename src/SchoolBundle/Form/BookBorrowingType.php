<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class BookBorrowingType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('daysOfBorrowing', TextType::class, array('label' => 'Nombre de jours' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de jours...')))
        ->add('madeAt', DateType::class, array(
                        'label' => 'Fait le',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Fait le...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ->add('student', EntityType::class, array('label' => 'Sélectionnez l\'étudiant', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez l\'étudiant...'), 'class' => 'SchoolBundle:Student', 'choice_label' => 'longname'))
        ->add('books', EntityType::class, array('label' => 'Sélectionnez les documents', 'multiple' => true, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez les documents...'), 'class' => 'SchoolBundle:Book', 'choice_label' => 'longname'))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\BookBorrowing'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_bookborrowing';
    }


}
