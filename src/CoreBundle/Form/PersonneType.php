<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

use CoreBundle\Entity\User;

class PersonneType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom de la personne...')))
            ->add('surname', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Prénom de la personne...')))
            ->add('civility', ChoiceType::class, array('label' => 'Civilité' ,'attr' => array('class' => 'form-control', 'placeholder' => 'Civilité...'), 'choices' => array('Monsieur' => 'M', 'Madame' => 'Mme', 'Mademoiselle' => 'Mlle'), 'preferred_choices' => array('Monsieur')))
            ->add('email', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'E-mail de la personne...')))
            ->add('telephone', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Téléphone...')))

            ->add('identifiant', TextType::class, array('label' =>'Numéro de la pièce', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Numéro identifiant...')))
            ->add('identifiantType', ChoiceType::class, array( 'required' => true,'label' =>'Type de pièce d\'identité',
                                                                'choice_attr' => function($val, $key, $index) {
                                                                    // adds a class like attending_yes, attending_no, etc
                                                                    return ['class' => ''];
                                                                } , 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Civilité...'), 'choices' => User::IDENTIFIANT_TYPES))
            ->add('dateNaissance', DateTimeType::class, array(
                        'label' => 'Date de naissance',
                        'required' => false,
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'datepicker form-control', 'placeholder' => 'Date de naissance...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('lieuNaissance', TextType::class, array('label' =>'Lieu de naissance', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lieu de naissance...')))
            ->add('regionOrigine', EntityType::class, array('label' => 'Sélectionnez la région d\'origine', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez la région d\'origine...'), 'class' => 'CoreBundle:Region', 'choice_label' => 'name'))
            ->add('competence', TextareaType::class, array('label' =>'Compétences', 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Compétences (séparée par des points virgules)...')))
            ->add('description', TextareaType::class, array('label' =>'Description', 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Description de la personne...')))
            ->add('domaines', EntityType::class, array('label' => 'Sélectionnez les domaines', 'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez domaines...'), 'class' => 'CoreBundle:Domaine', 'choice_label' => 'name'))
            
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Personne'
        ));
    }
}
