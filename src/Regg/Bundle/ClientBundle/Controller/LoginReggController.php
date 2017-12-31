<?php

namespace Regg\Bundle\ClientBundle\Controller;

use Doctrine\Common\Persistence\ObjectManager;
use Regg\Bundle\ClientBundle\Entity\User;
use Regg\Bundle\ClientBundle\Form\UserType;
use Regg\Bundle\ClientBundle\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Regg\Bundle\ClientBundle\Form\ClientType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\Security;

class LoginReggController extends Controller
{
    /**
     * @param Request $request
     * @Route("/login", name="regg_login")
     */
    public function loginreggAction(Request $request)
    {
        $post = new User();
        $form = $this->createForm(UserType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var UserService
             */
            $userService=$this->getUserService();
            $userService->findBy();
            return $this->redirectToRoute('regg_access');
        }



        return $this->render('ReggClientBundle:LoginRegg:loginregg.html.twig', array('form'=>$form->createView()
            // ...
        ));
    }

    /**
     * @Route("/access", name="regg_access")
     */
    public function accessAction()
    {
        return $this->render('ReggClientBundle:LoginRegg:access.html.twig', array(
            // ...
        ));
    }

    /**
     * @param  Request $request
     * @Route("/register", name="regg_register")
     */
    public function registerreggAction(Request $request)
    {

        $post = new User();
        $form = $this->createForm(UserType::class, $post);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            /**
             * @var UserService
             */
            $userService=$this->getUserService();
            /**
             * @var User
             */
            $user=$form->getData();
            $userService->register($user);

            return $this->redirectToRoute('regg_login');
        }


        return $this->render('ReggClientBundle:LoginRegg:registerregg.html.twig', array('form'=>$form->createView()
            // ...
        ));
    }
    public function getUserService()
    {
        return $this->get('user_regg.user_service');

    }

}
