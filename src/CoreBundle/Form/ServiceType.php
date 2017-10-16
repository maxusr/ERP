<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class ServiceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('label' => 'Nom' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom du service...')))
            ->add('competence', TextareaType::class, array('label' => 'Compétence' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Compétences requises...')))
            ->add('profil', TextareaType::class, array('label' => 'Profil requis' ,'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Profil requis...')))
            ->add('discipline', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Discipline requise...')))
            ->add('domaines', EntityType::class, array('label' => 'Sélectionnez les domaines requis', 'multiple' => true, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez domaines requis...'), 'class' => 'CoreBundle:Domaine', 'choice_label' => 'name'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Service'
        ));
    }
}
