<?php

namespace App\Form;

use App\Entity\Task;
use App\Form\DataTransformer\CategoryTransformer;
use App\Form\DataTransformer\IssueToNumberTransformer;
use App\Form\Type\CategoryType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TaskType extends AbstractType
{
    private $transformer;

    private $categoryTransformer;

    public function __construct(IssueToNumberTransformer $transformer, CategoryTransformer $categoryTransformer)
    {
        $this->transformer = $transformer;
        $this->categoryTransformer = $categoryTransformer;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('task')
            ->add('dueDate')
            //->add('category', CategoryType::class)
            ->add('category', TextType::class, [
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid category name'
            ])
            ->add('agreeTerms', CheckboxType::class, ['mapped' => false])
            ->add('tags', TextType::class, ['mapped' => false])
            //->add('issue', TextType::class)
            ->add('issue', IssueSelectorType::class, [
                // validation message if the data transformer fails
                'invalid_message' => 'That is not a valid issue number'
            ])
            ->add('save', SubmitType::class)
        ;

/*        $builder->get('tags')
            ->addModelTransformer(new CallbackTransformer(
                function ($tagsAsArray) {
                    // transform the array to a string
                    return implode(",", $tagsAsArray);
                },
                function ($tagsAsString){
                    // transform the string back to an array
                    return explode(',', $tagsAsString);
                }
            ))*/

        ;

        $builder->get('category')
            ->addModelTransformer($this->categoryTransformer);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Task::class,
            'require_due_date' => false,
            // enable/disable CSRF protection for this form
            'csrf_protection' => true,
            // the name of the hidden HTML field that stores the token
            'csrf_field_name' => '_token',
            // an arbitrary string used to generate the value of the token
            // using a different string for each form improves its security
            'csrf_token_id' => 'task_item',
        ]);

        // you can also define the allowed types, allowed values and
        // any other feature supported by the OptionsResolver component
        $resolver->setAllowedTypes('require_due_date', 'bool');
    }
}
