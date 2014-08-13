<?php

namespace Ballet\WaytocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class FrontController extends Controller
{
    public function indexAction()
    {
        return $this->render('BalletWaytocBundle:Default:index.html.twig');
    }

    public function aboutAction(){
        return $this->render('BalletWaytocBundle:Default:about.html.twig');
    }
}
