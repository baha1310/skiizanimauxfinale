<?php

namespace AnnonceBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnimalType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    { $builder->add('nom',null,array('label'=> 'Nom','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
        ->add('age',null,array('label'=> 'Age','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
        ->add('type',null,array('label'=> 'Type','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
        ->add('race',null,array('label'=> 'Race','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
        ->add('poids',null,array('label'=> 'poids','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
       ->add('image', FileType::class, array('data_class' => null,'label' => 'insérer une image','attr'=>array('style'=>'color:violet','class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
        ->add('sexe',ChoiceType::class,array('choices'=>array(
            'Femelle'=>'Femelle',
            'Male'=>'Male')))
        ->add('Ajouter',SubmitType::class,array('label'=> 'Valider','attr'=>array('class'=>'btn btn-primary', 'style'=>'background-color:red;border-color:red')));

        ; }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Animal'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_animal';
    }


}
