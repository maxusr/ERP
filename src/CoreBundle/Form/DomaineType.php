<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class DomaineType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Nom du domaine...')))
            ->add('description', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Description du domaine...')))
            ->add('competence', TextareaType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Compétences requises...')))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Domaine'
        ));
    }
}
