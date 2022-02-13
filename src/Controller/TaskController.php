<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/task")
 */
class TaskController extends AbstractController
{

    /**
     * @Route("/new", name="app_task_new")
     * @param Request $request
     * @return Response
     */
    public function new(Request $request): Response
    {

        //just setup a fresh $task object (remove the example data)
        $task = new Task();

        //use some PHP logic to decide if this form field is required or not
        $dueDateIsRequired =  true;

        $form = $this->createForm(TaskType::class, $task, [
            'action' => $this->generateUrl('app_task_new'),
            'method' => 'POST',
            'require_due_date' => $dueDateIsRequired,
        ]);

        $form = $this->get('form.factory')->createNamed('my_name', TaskType::class, $task);


        $form->handleRequest($request);
        if($request->isMethod('POST'))
        {
            //$form->submit($request->request->get($form->getName()));
            if ($form->isSubmitted() && $form->isValid())
            {
                $task = $form->getData();

                //.. perform some action, such as saving the task to the database
                // for example is Task is a Doctrine Entity, save it
                 $entityManager = $this->getDoctrine()->getManager();
                 $entityManager->persist($task);
                 $entityManager->flush();

                return $this->redirectToRoute(('task_success'));
            }
        }


        return $this->render('task/new.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/task_success", name="task_success")
     */
    public function taskSuccess()
    {
        return $this->render('task/success.html.twig');
    }
}