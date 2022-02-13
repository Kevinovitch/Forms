<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;

class OrderType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            // ...
            ->add('shipping', ShippingType::class)
            ->add('address', PostalAddressType::class, [
                'is_extended_address' => true,
                'allowed_states' => ['CA', 'FL', 'TX'],
                // in this example, this config would also be valid
                // 'allowed_states' => 'CA',
            ])
            ->add('name', TextType::class, [
                'block_name' => 'wrapped_text',
            ])
        ;
    }

}