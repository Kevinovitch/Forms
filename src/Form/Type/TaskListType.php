<?php

namespace App\Form\Type;

use App\Form\TaskType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskListType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tasks', CollectionType::class, [
            'entry_type' => TaskType::class
        ]);
    }

}