<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

use CoreBundle\Entity\Competence;

class CompetenceType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', ChoiceType::class, array('label' =>'Sélectionnez la condition', 'required' => true, 'expanded' => false, 'multiple' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Sélectionnez la condition...'), 'choices' => Competence::NAMES))
            ->add('comparator', ChoiceType::class, array('label' =>'Sélectionnez le comparateur', 'required' => true, 'expanded' => false, 'multiple' => false,'attr' => array('class' => 'form-control', 'placeholder' => 'Sélectionnez le comparateur...'), 'choices' => Competence::COMPARATORS))
            ->add('value', TextType::class, array('required' => false, 'attr' => array('class' => 'form-control', 'placeholder' => 'Valeur...')))
            ->add('poste', EntityType::class, array('label' => 'Sélectionnez le poste correspondant', 'multiple' => false, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez le poste...'), 'class' => 'CoreBundle:Poste', 'choice_label' => 'name'))
            ->add('service', EntityType::class, array('label' => 'Sélectionnez le service correspondant', 'multiple' => false, 'required' => false, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez le service...'), 'class' => 'CoreBundle:Service', 'choice_label' => 'name'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Competence'
        ));
    }
}
