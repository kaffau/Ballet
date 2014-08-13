<?php

namespace Ballet\WaytocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BalletWaytocBundle:Default:index.html.twig', array('name' => $name));
    }
}
