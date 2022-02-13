<?php

namespace App\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;

class SubscriptionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
       $builder
           ->add('username', TextType::class)
           ->add('showEmail', CheckboxType::class)
           ->addEventListener(
               FormEvents::PRE_SUBMIT,
               [$this, 'onPreSubmitData']
           )
       ;
    }

    public function onPreSubmitData(FormEvent $event)
    {
        $user = $event->getData();
        $form = $event->getForm();

        if(!$user){
            return;
        }

        //checks whether the User has chosen to display their email or not
        // If the data was submitted previously, the additional value that is
        // included in the request variables needs ti be removed
        if(isset($user['showEmail']) && $user['showEmail']) {
            $form->add('email', EmailType::class);
        } else{
            unset($user['email']);
            $event->setData($user);
        }
    }


}