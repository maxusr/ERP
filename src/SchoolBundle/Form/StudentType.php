<?php

namespace SchoolBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use SchoolBundle\Entity\Student;

class StudentType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('firstname', TextType::class, array('label' => 'Nom(s)' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom(s)...')))
        ->add('lastname', TextType::class, array('label' => 'Prénom(s)' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Prénom(s)...')))
        ->add('birthday', DateType::class, array(
                        'label' => 'Date de naissance',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de naissance...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
        ->add('matricule', TextType::class, array('label' => 'Matricule' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Matricule...')))
        ->add('classrooms', EntityType::class, array('label' => 'Sélectionnez les salles effectuées', 'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez les salles effectuées...'), 'class' => 'SchoolBundle:Classroom', 'choice_label' => 'name'))
        ->add('currentClassroom', EntityType::class, array('label' => 'Sélectionnez sa salle actuelle', 'multiple' => false, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez sa salle actuelle...'), 'class' => 'SchoolBundle:Classroom', 'choice_label' => 'name'))
        ->add('status', ChoiceType::class, array('label' =>'Statut', 'required' => true, 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'radios', 'placeholder' => 'Statut...'), 'choices' => Student::STATUS))
        ->add('nationality', TextType::class, array('label' => 'Nationalité' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nationalité...')))
        ->add('telephone', TextType::class, array('label' => 'Téléphone' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Téléphone...')))
        ->add('email', TextType::class, array('label' => 'E-mail' ,'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'E-mail...')))        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'SchoolBundle\Entity\Student'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'schoolbundle_student';
    }


}
