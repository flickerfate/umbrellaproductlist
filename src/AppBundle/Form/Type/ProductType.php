<?php

namespace AppBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->setAction('/save')
            ->setMethod('POST')
            ->add('title',"text",array(
                'max_length'=>100,
                'attr' => array(
                    'placeholder' => "New title",
                )
            ))
            ->add('description', "textarea")
            ->add('id', 'hidden')
            ->add('save', 'submit',array(
                 'attr' => array(
                     'class' => "btn-primary"
                 )
            ));
    }

    public function getName()
    {
        return 'product';
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Product',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            // a unique key to help generate the secret token
            'intention'       => 'product_item',
        ));
    }
}