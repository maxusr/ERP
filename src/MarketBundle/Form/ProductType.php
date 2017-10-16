<?php

namespace MarketBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class ProductType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', TextType::class, array('label' => 'Nom', 'attr' => array('class' => 'form-control')))
                ->add('quantity', NumberType::class, array('label' => 'Quantité', 'attr' => array('class' => 'form-control')))
                ->add('observation', TextareaType::class, array('label' => 'Observatiion', 'required' => false, 'attr' => array('class' => 'form-control')))
                ->add('price', TextType::class, array('label' => 'Prix(FCFA)', 'attr' => array('class' => 'form-control')))       
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'MarketBundle\Entity\Product'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'marketbundle_product';
    }


}
