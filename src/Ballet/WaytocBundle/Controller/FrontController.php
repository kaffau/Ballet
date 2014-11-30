<?php

namespace Ballet\WaytocBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Ballet\WaytocBundle\Entity\User;



class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('BalletWaytocBundle:Default:index.html.twig');
    }

    public function aboutAction()
    {
//        $user = new User();
//        $user->setId(2);
//        $user->setName("Vincas");
//        $user->setPassword("sakes");
//        $user->setCity("Kaunas");
//        $now= new \DateTime("now");
//        $user->setRegisterDate($now);
//        $user->setUpdateDate($now);
//        $user->setEmail('algis@gmail.com');
//        $user->setUserType('3');
//
//        $em = $this->getDoctrine()->getManager();
//        $em->persist($user);
//        $em->flush();

        $user = $this->getDoctrine()
            ->getRepository('BalletWaytocBundle:User')->findAll();

//        return new Response('Created user from '.$user->getCity());
//        array('users'=> $user)
//        $number = rand(1,100);

        return $this->render('BalletWaytocBundle:Default:about.html.twig', array('user' => $user));
    }

    public function infoAction(){
        return $this->render('BalletWaytocBundle:Default:info.html.twig');
    }
    public function createAction()
    {

    }

    public function pracAction(){
        return $this->render('BalletWaytocBundle:Default:delete.html.twig');
    }
}
