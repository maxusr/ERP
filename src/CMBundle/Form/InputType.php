<?php

namespace CMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class InputType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', NumberType::class, array('label' => 'Quantité', 'attr' => array('class' => 'form-control')))
            ->add('product', EntityType::class, array('label' => 'Sélectionnez le produit', 'class' => 'CMBundle:Product', 'choice_label' => 'name', 'attr' => array('class' => 'form-control')))
            
            ->add('employeeBorrower', EntityType::class, array('required' => false, 'class' => 'CoreBundle:User', 'choice_label' => 'longname', 'label' => 'Employé déposeur', 'attr' => array('class' => 'form-control')))
            ->add('borrower', BorrowerType::class, array('required' => false, 'label' => 'Déposeur'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMBundle\Entity\Input'
        ));
    }
}
