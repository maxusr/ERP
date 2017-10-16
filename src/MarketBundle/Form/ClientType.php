<?php

namespace MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class ClientType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
                ->add('telephone', TextType::class, array('label' => 'Téléphone', 'attr' => array('class' => 'form-control')))
                ->add('email', TextType::class, array('label' => 'E-mail', 'attr' => array('class' => 'form-control')))
                ->add('category', ChoiceType::class, array('label' => 'Categorie', 'choices' => ['Partenaire' => 'Partenaire', 'Personnel' => 'Personnel', 'Entreprise' => 'Entreprise', 'Individuel' => 'Individuel'], 'attr' => array('class' => 'form-control')))
                ->add('localisation', TextareaType::class, array('label' => 'Localisation', 'attr' => array('class' => 'form-control')))        
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketBundle\Entity\Client'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketbundle_client';
    }


}
