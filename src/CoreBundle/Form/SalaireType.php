<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use CoreBundle\Entity\Salaire;

class SalaireType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('montant', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Montant du salaire...')))
            ->add('duration', TextType::class, array('required' => true, 'label' => 'Durée du mois (Jours)' , 'attr' => array('class' => 'form-control', 'placeholder' => 'Durée du mois (Jours)...')))
            ->add('taxes', EntityType::class, array('label' => 'Sélectionnez les taxes', 'multiple' => true, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez taxes...'), 'class' => 'CoreBundle:Taxe', 'choice_label' => 'name'))
            ->add('datePaiement', ChoiceType::class, array('label' =>'Jour du mois de paiement', 'expanded' => false, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Jour du mois...'), 'choices' => Salaire::dates()))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Salaire'
        ));
    }
}
