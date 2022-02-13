<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;

class TaskManagerType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('tasklists', CollectionType::class, [
            'entry_type' => TaskListType::class,
            'block_name' => 'task_lists'
        ]);
    }

}