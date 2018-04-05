<?php

namespace AnnonceBundle\Form;



use Doctrine\DBAL\Types\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;

use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MailType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
             ->add('subject',TextType::class,array('attr'=>array('class'=>"form-control", 'style'=>"border-color: #2ed3aa", 'placeholder'=>"Subject")))
            ->add('text',TextType::class,array('attr'=>array('rows'=>"8", 'cols'=>"80",  'class'=>"form-control" ,'style'=>"height:300px;border-color: #2ed3aa")))
            ->add('valider',SubmitType::class,array('label'=>'Send','attr'=>array('class'=>"btn btn-purple waves-effect waves-light" ,'style'=>"border-color: #2ed3aa")));

    }
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'UserBundle\Entity\Mail'
        ));
    }

    public function getBlockPrefix()
    {
        return 'userbundle_mail';
    }
}
