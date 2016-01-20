<?php

namespace Ballet\PostBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class VotingType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('voter', new VotingType());
        $builder->add('age', 'text');
        $builder->add('save', 'submit', array('label' => 'Vote'));
    }

    public function getName()
    {
        return 'voting';
    }
}