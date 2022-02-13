<?php

namespace App\Controller;

use App\Form\EventListener\AddEmailFieldListener;
use App\Form\Type\OrderType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/order")
 */
class OrderController extends AbstractController
{
    /**
     * @Route("/new", name="app_order_new")
     */
    public function newAction(Request $request)
    {
        $orderForm = $this->createForm(OrderType::class);

        return $this->render('order/new.html.twig', [
            'form' => $orderForm->createView(),
        ]);

    }

    /**
     * This a just an example in the section "Event Listeners"
     * in the page Form Events
     *
     * @Route("/show-email", name="app_order_show_email")
     */
    public function showEmailType(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('showEmail', CheckboxType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, function (FormEvent $event){
                $user = $event->getData();
                $form = $event->getForm();

                if (!$user) {
                    return;
                }

                // checks whether the user has chosen to display their email or not
                // If the data was submitted previously, the additional value that is
                // included in the request variables needs to be removed
                if (isset($user['showEmail']) && $user['showEmail']) {
                    $form->add('email', EmailType::class);
                } else {
                    unset($user['email']);
                    $event->setData($user);
                }
            })
            ->getForm();

        return $this->render('order/show_email.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * This a just an example in the section "Event Subscriber"
     * in the page Form Events
     *
     * @Route("/show-email-two", name="app_order_show_email_two")
     */
    public function showEmailTypeTwo(Request $request)
    {
        $form = $this->createFormBuilder()
            ->add('username', TextType::class)
            ->add('showEmail', CheckboxType::class)
            ->addEventSubscriber(new AddEmailFieldListener())

            ->getForm();

        return $this->render('order/show_email_two.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}