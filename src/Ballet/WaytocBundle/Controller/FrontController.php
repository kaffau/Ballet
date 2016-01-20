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
}