<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use CoreBundle\Entity\Echelon;

class EchelonType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('niveau', ChoiceType::class, array('label' => 'Sélectionnez le niveau de l\'échelon' ,'multiple' => false,'label_attr' => array('class' => ''),
                                                                'choice_attr' => function($val, $key, $index) {
                                                                    // adds a class like attending_yes, attending_no, etc
                                                                    return ['class' => ''];
                                                                } , 'expanded' => false ,'attr' => array('class' => 'form-control', 'placeholder' => 'Sélectionnez le niveau de l\'échelon'), 'choices' => Echelon::NIVEAUX))
            ->add('designation', TextType::class, array('label' =>'Désignation de l\'échelon', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Désignation...')))
            ->add('dureeConge', TextType::class, array('label' =>'Durée d\'un congé (jours)', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Durée d\'un congé (jours)...')))
            ->add('poste', EntityType::class, array('label' => 'Sélectionnez le poste correspondant', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez le poste...'), 'class' => 'CoreBundle:Poste', 'choice_label' => 'name'))
            ->add('salaire', SalaireType::class)
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Echelon'
        ));
    }
}
