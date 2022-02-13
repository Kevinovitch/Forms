<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(Request $request, $id)
    {
        $submittedToken = $request->request->get('token');
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('App:User')->find($id);

        // 'delete-item' is the same value in the template to generate the token
        if ($this->isCsrfTokenValid('delete-item', $submittedToken)) {

            $currentUserId = $this->getUser()->getId();
            if($currentUserId == $id)
            {
                $session = $this->get('session');
                $session = new Session();
                $session->invalidate();
            }

            //$em->persist($user);
            $em->remove($user);
            $em->flush();

            return $this->redirectToRoute("app_login");

        }

        return $this->render('security/delete.html.twig', [
            'user' => $user,
        ]);
    }
}
