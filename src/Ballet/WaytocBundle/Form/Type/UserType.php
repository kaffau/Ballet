<?php

namespace Ballet\WaytocBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('email', 'email', array('label' => 'Email', 'attr' => array('class' => 'form-control')));
        $builder->add('username','text', array('label' => 'Username', 'attr' => array('class' => 'form-control')));
        $builder->add('password', 'repeated', array(
                'first_name'  => 'password',
                'second_name' => 'confirm',
                'type'        => 'password',
            ));
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
                'data_class' => 'Ballet\WaytocBundle\Entity\User'
            ));
    }

    public function getName()
    {
        return 'user';
    }
}