<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StudentNoteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('note', TextType::class, array('label' => 'Note' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Note...')))
        ->add('student', EntityType::class, array('label' => 'Sélectionnez l\'étudiant', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez l\'étudiant...'), 'class' => 'SchoolBundle:Student', 'choice_label' => 'longname'))
        ->add('matter', EntityType::class, array('label' => 'Sélectionnez la matière', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez la matière...'), 'class' => 'SchoolBundle:Matter', 'choice_label' => 'name'))
        ->add('exam', EntityType::class, array('label' => 'Sélectionnez l\'examen', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez l\'examen...'), 'class' => 'SchoolBundle:Exam', 'choice_label' => 'name'))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\StudentNote'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_studentnote';
    }


}
