<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class ShoeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('model', TextType::class)
            ->add('brand', TextType::class)
            ->add('isfav', TextType::class)
            ->add('isnew', TextType::class)
            ->add('price', TextType::class)
            ->add('url', TextType::class)
            ->add('save', SubmitType::class);
        
    }
}
