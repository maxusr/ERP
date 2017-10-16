<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use CoreBundle\Entity\Rappel;

class RappelType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('dateRappel', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control datepicker', 'placeholder' => 'Date du rappel...')))
            ->add('heureRappel', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control time-mask', 'placeholder' => 'Heure du rappel...')))
            ->add('content', TextareaType::class, array('label' =>'Contenu', 'required' => false, 'attr' => array('rows' => 5,'class' => 'form-control', 'placeholder' => 'Contenu...')))
            ->add('avant', ChoiceType::class, array('label' =>'Avant', 'expanded' => true, 'multiple' => false,'attr' => array('class' => 'checkboxes', 'placeholder' => 'Avant...'), 'choices' => Rappel::AVANT))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Rappel'
        ));
    }
}
