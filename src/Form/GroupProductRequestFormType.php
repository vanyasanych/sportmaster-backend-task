<?php

namespace App\Form;

use App\DTO\Request\GroupProductRequest;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class GroupProductRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('product_id', EntityType::class, [
                'class' => Product::class,
                'property_path' => 'product',
            ])
            ->add('product_count', IntegerType::class, [
                'property_path' => 'count'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => GroupProductRequest::class,
        ]);
    }
}