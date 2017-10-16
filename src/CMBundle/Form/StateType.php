<?php

namespace CMBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class StateType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('description', TextType::class, array('label' => 'Description', 'attr' => array('class' => 'form-control')))
            ->add('product', EntityType::class, array('label' => 'Sélectionnez le matériel', 'class' => 'CMBundle:Product', 'choice_label' => 'name', 'attr' => array('class' => 'form-control')))
            ->add('note', TextareaType::class, array('label' => 'Note supplémentaire', 'required' => false, 'attr' => array('class' => 'form-control')))
            ->add('isAvailable', CheckboxType::class, array('label' => 'Disponible?','label_attr' => array('class' => ''), 'required' => false, 'attr' => array('class' => 'checkboxes')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CMBundle\Entity\State'
        ));
    }
}
