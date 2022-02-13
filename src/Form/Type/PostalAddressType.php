<?php

namespace App\Form\Type;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostalAddressType extends AbstractType
{
    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('addressLine1', TextType::class, [
                'help' => 'Street address, P.O. box, company name'
            ])
            ->add('addressLine2', TextType::class, [
                'help' => 'Street address, P.O. box, company name'
            ])
            ->add('city', TextType::class)
            ->add('state', TextType::class, [
                'label' => 'State',
            ])
            ->add('zipCode', TextType::class, [
                'label' => 'ZIP Code'
            ]);

            if(true === $options['is_extended_address']){
                $builder->add('addressLine3', TextType::class, [
                    'help' => 'Extended address info'
                ]);
            }

            if(null !== $options['allowed_states']) {
                $builder->add('state', ChoiceType::class, [
                    'choices' => $options['allowed_states'],
                ]);
            } else {
                $builder->add('state', TextType::class, [
                    'label' => 'State/Province/Region',
                ]);
            }
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        // this defines the available options and their default values when
        // they are not configured explicitly when using the form type
        $resolver->setDefaults([
            'allowed_states' => null,
            'is_extended_address' => false,
        ]);

        // optionally you can also restrict the options type or types (to get
        // automatic type validation and useful error messages for end users)
        $resolver->setAllowedTypes('allowed_states', ['null', 'string', 'array']);
        $resolver->setAllowedTypes('is_extended_address', 'bool');

        // optionally you can transform the given values for the options to
        // simplify the further processing of those options
        $resolver->setNormalizer('allowed_states', static function(Options $options, $states) {
            if(null === $states)
            {
                return $states;
            }

            if(is_string($states))
            {
                $states = (array) $states;
            }

            return array_combine(array_values($states), array_values($states));
        });


    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // pass the form type option directly to the template
        $view->vars['isExtendedAddress'] = $options['is_extended_address'];

        // make a database query to find possible notifications related to postal addresses (e.g to
        // display dynamic messages such as 'Delivery to XX and YY states will be added next week!')
        //$view->vars['notification'] = $this->entityManager->find('...');
    }
}