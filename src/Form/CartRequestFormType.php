<?php

namespace App\Form;

use App\DTO\Request\CartRequest;
use App\Entity\Product;
use App\Form\EntityForm\ProductIdFormType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CartRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('product_groups', CollectionType::class, [
            'entry_type' => GroupProductRequestFormType::class,
            'property_path' => 'groupProducts',
            'allow_extra_fields' => true,
            'allow_add' => true,
        ]);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => CartRequest::class,
        ]);
    }
}
