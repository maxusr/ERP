<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use CoreBundle\Entity\Dossier;

class DossierType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Designation...')))
            ->add('numero', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Numéro du dossier...')))
            ->add('type', ChoiceType::class, array('label' =>'Type de dossier', 'expanded' => false, 'multiple' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Type de dossier...'), 'choices' => Dossier::TYPES))
            ->add('dateDepot', DateTimeType::class, array(
                        'label' => 'Date de dépot',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de dépot...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            
            ->add('personne', PersonneType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Description du domaine...')))
            ->add('domaine', EntityType::class, array('label' => 'Sélectionnez le domaine', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez domaine...'), 'class' => 'CoreBundle:Domaine', 'choice_label' => 'name'))
            ->add('documents', FileType::class, array('label' => 'Sélectionnez les pièces jointes' ,'data_class' => null ,'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control input-docs', 'placeholder' => 'Pièces jointes...')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Dossier'
        ));
    }
}
