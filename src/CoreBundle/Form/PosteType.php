<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use CoreBundle\Entity\Poste;

class PosteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom du poste...')))
            ->add('number', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nombre de poste disponible...')))
            ->add('attribution', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Attribution...')))
            ->add('profil', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Profil du poste...')))
            ->add('categorie', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Catégorie (min: 1, max: 12)...')))
            ->add('service', EntityType::class, array('label' => 'Sélectionnez son service', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez son service...'), 'class' => 'CoreBundle:Service', 'choice_label' => 'name'))
            ->add('domaines', EntityType::class, array('label' => 'Sélectionnez les domaines requis', 'multiple' => true, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez domaines requis...'), 'class' => 'CoreBundle:Domaine', 'choice_label' => 'name'))
            ->add('permissions', ChoiceType::class, array('label' => 'Cochez les permissions accordées' ,'multiple' => true,'label_attr' => array('class' => ''),
                                                                'choice_attr' => function($val, $key, $index) {
                                                                    // adds a class like attending_yes, attending_no, etc
                                                                    return ['class' => ''];
                                                                } , 'expanded' => true ,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Permissions...'), 'choices' => Poste::$_permissions))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Poste'
        ));
    }
}
