<?php

namespace MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

class CommandeType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('reference', TextType::class, array('label' => 'Reférence', 'attr' => array('class' => 'form-control')))
                ->add('observation', TextareaType::class, array('label' => 'Observation', 'attr' => array('class' => 'form-control')))
                ->add('billingMode', ChoiceType::class, array('label' => 'Mode de paiement', 'choices' => ['Avance' => 'Avance', 'Livraison' => 'Livraison'], 'attr' => array('class' => 'form-control')))
                ->add('shippingMode', ChoiceType::class, array('label' => 'Mode de livraison', 'choices' => ['Domicile' => 'Domicile', 'Entreprise' => 'Entreprise'], 'attr' => array('class' => 'form-control')))
                ->add('shippingCost', TextType::class, array('label' => 'Prix Livraison', 'attr' => array('class' => 'form-control')))
                ->add('items', CollectionType::class, array(
                    'entry_type' => CommandeItemType::class,
                    'allow_add' => true,
                    'allow_delete' => true,
                    'entry_options' => array(
                        'attr' => array('class' => '')
                    )
                ))
                ->add('client', EntityType::class, array('label' => 'Sélectionnez un client', 'class' => 'MarketBundle:Client', 'choice_label' => 'name', 'attr' => array('class' => 'form-control')))    
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketBundle\Entity\Commande'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketbundle_commande';
    }


}
