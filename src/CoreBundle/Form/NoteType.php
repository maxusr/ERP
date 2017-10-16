<?php

namespace CoreBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class NoteType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('content', TextareaType::class, array('label' =>'Contenu de la note', 'required' => false, 'attr' => array('rows' => 5,'class' => 'form-control', 'placeholder' => 'Entrez la note...')))
            ->add('title', TextType::class, array('required' => true, 'attr' => array('class' => 'form-control', 'placeholder' => 'Titre de la note...')))

            ->add('receivers', EntityType::class, array('label' => 'Sélectionnez les destinaires', 'multiple' => true, 'required' => true, 'attr' => array('class' => 'form-control' ,'data-placeholder' => 'Sélectionnez destinaires...'), 'class' => 'CoreBundle:User', 'choice_label' => 'longname', 'group_by' => 'domaine.name'))
        ;
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'CoreBundle\Entity\Note'
        ));
    }
}
