<?php

namespace MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class CommandeItemType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product', EntityType::class, array('label' => 'Sélectionnez un produit', 'class' => 'MarketBundle:ProductVariant', 'choice_label' => 'name', 'attr' => array('class' => 'form-control')))
                ->add('quantity', NumberType::class, array('label' => 'Quantité', 'attr' => array('class' => 'form-control')))
                
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketBundle\Entity\CommandeItem'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketbundle_commandeitem';
    }


}
