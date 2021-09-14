<?php

namespace App\Form;

use App\DTO\Request\InventoryRequest;
use App\Entity\Product;
use App\Entity\Store;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class InventoryRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('quantity', IntegerType::class)
            ->add('store_id', EntityType::class, [
                'class' => Store::class,
                'property_path' => 'store',
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                ],
            ])
            ->add('product_id', EntityType::class, [
                'class' => Product::class,
                'property_path' => 'product',
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'allow_extra_fields' => true,
            'data_class' => InventoryRequest::class,
        ]);
    }
}
