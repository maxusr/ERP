<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use CoreBundle\Entity\User;

class UserType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateEmbauche', DateType::class, array(
                        'label' => 'Date d\'embauche',
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'form-control datepicker', 'placeholder' => 'Date d\'embauche...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le nom...')))
            ->add('surname', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le prénom...')))
            ->add('civility', ChoiceType::class, array('label' => 'Civilité' ,'attr' => array('class' => 'form-control', 'placeholder' => 'Civilité...'), 'choices' => array('Monsieur' => 'M', 'Madame' => 'Mme', 'Mademoiselle' => 'Mlle', 'Docteur' => 'Dr', 'Professeur' => 'Pr'), 'preferred_choices' => array('Monsieur')))
            ->add('telephone', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le téléphone...')))
            ->add('email', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Entrez l\'adresse mail...')))
            ->add('password' , RepeatedType::class, array(
                                                    'type' => PasswordType::class,
                                                    'first_options' => array('label' => 'Mot de passe','attr' => array('class' => 'form-control', 'placeholder' => 'Entrez le mot de passe...')),
                                                    'second_options' => array('label' => 'Repéter le mot de passe','attr' => array('class' => 'form-control', 'placeholder' => 'Retapez le mot de passe...')),
                                                    ))
            ->add('identifiant', TextType::class, array('label' =>'Numéro de la pièce', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Numéro identifiant...')))
            ->add('identifiantType', ChoiceType::class, array('label' =>'Type de pièce d\'identité', 'required' => true, 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Civilité...'), 'choices' => User::IDENTIFIANT_TYPES))
            ->add('dateNaissance', DateType::class, array(
                        'label' => 'Date de naissance',
                        'widget' => 'single_text',
                        'html5' => false,
                        'attr' => array('class' => 'form-control datepicker', 'placeholder' => 'Date de naissance...'),
                        // this is actually the default format for single_text
                        'format' => 'dd-MM-yyyy',
                    ))
            ->add('lieuNaissance', TextType::class, array('label' =>'Lieu de naissance', 'required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Lieu de naissance...')))
            ->add('regionOrigine', EntityType::class, array('label' => 'Sélectionnez la région d\'origine', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez la région d\'origine...'), 'class' => 'CoreBundle:Region', 'choice_label' => 'name'))
            ->add('domicile', TextareaType::class, array('label' =>'Domicile', 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Domicile...')))
            ->add('competence', TextareaType::class, array('label' =>'Compétences', 'required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Compétences (séparée par des points virgules)...')))
            ->add('domaine', EntityType::class, array('label' => 'Sélectionnez son domaine', 'multiple' => false, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez son domaine...'), 'class' => 'CoreBundle:Domaine', 'choice_label' => 'name'))
            ->add('contrat', ContratType::class, array('label' => 'Contrat', 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Contrat...')))

            ->add('photo', FileType::class, array('required' => false, 'data_class' => null, 'label' => 'Photo de profil', 'attr' => array('class' => 'form-control input-file')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\User'
        ));
    }
}
