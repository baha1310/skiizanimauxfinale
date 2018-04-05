<?php

namespace AnnonceBundle\Form;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AnnonceType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('titre_annonce',null,array('label'=> 'Titre','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
            ->add('description_annonce',null,array('label'=> 'Description','attr'=>array('class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
           ->add('image', FileType::class, array('data_class' => null,'label' => 'insérer une image','attr'=>array('style'=>'color:violet','class'=>'text-muted m-b-15 f-s-12 form-control input-focus')))
            ->add('type_annonce',ChoiceType::class,array('choices'=>array(
                'Adoption'=>'Adoption',
                'Vente'=>'Vente',
                'Accouplement'=>'Accouplement')))
            ->add('Ajouter',SubmitType::class,array('label'=> 'Valider','attr'=>array('class'=>'btn btn-primary', 'style'=>'background-color:red;border-color:red')));

        ;
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Annonce'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'userbundle_annonce';
    }


}
