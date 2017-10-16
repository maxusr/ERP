<?php

namespace MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;

class SaleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
                ->add('taxe', TextType::class, array('label' => 'Taxe(%)', 'attr' => array('class' => 'form-control')))
                ->add('receive', TextType::class, array('label' => 'Montant reçu(FCFA)', 'attr' => array('class' => 'form-control')))
                ->add('commandes', EntityType::class, array('label' => 'Sélectionnez les commandes', 'multiple' => true , 'class' => 'MarketBundle:Commande', 'choice_label' => 'denomination', 'attr' => array('class' => 'form-control')))
                ->add('paid', CheckboxType::class, array('label' => 'Facture payé?', 'required' => false, 'attr' => array('class' => 'form-control')))       
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketBundle\Entity\Sale'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketbundle_sale';
    }


}
