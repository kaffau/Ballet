<?php

namespace Ballet\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ballet\PostBundle\Entity\Image;
use Symfony\Component\Validator\Constraints\Null;
use Symfony\Component\HttpFoundation\Cookie;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('BalletPostBundle:Default:index.html.twig', array('name' => $name));
    }

    public function showImagesAction(Request $request)
    {
        $images = $this->getDoctrine()
            ->getRepository('BalletPostBundle:Image')->findBy(array(),array('picId' => 'DESC'));

//        $em = $this->getDoctrine()->getManager();
//        $image = new Image();
//        foreach($images as $img) {
//
//        }
//        $form = $this->createFormBuilder($image)
//            ->add('avrAge', 'text')
//            ->add('save', 'submit', array('label' => 'Vote'))
//            ->getForm();
//
//        $form->handleRequest($request);
//        if ($form->isValid()) {
//            $userId = $this->get('security.context')->getToken()->getUser()->getId();
//            $image->setUserid($userId);
//            $image = $form->getData();
//            $em->persist($image);
//            $em->flush();
//            return $this->redirect($this->generateUrl('front_page'));
//        }

        return $this->render('BalletWaytocBundle:Default:index.html.twig', array('image' => $images));
    }

    public function showImageAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('BalletPostBundle:Image')->findOneBy(array('picId' => $slug));
        $totalAge = $image->getAvrAge();
        $voters = $image->getVoters();
        $avrAge = null;
        if($totalAge > 0 && $voters != null) {
            $avrAge = $totalAge / $voters ;
        }

        $this->generateUrl('post_image', array('slug' => $slug));

        return $this->render('BalletPostBundle:Page:item.html.twig', array('slug' => $slug, 'image' => $image, 'age' => $avrAge));
    }

    public function voteAction(Request $request, $slug)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $this->getDoctrine()->getRepository('BalletPostBundle:Image')->find($slug);


        $ajaxAge = $request->request->get('age');
        $previousAge = $image->getAvrAge();
        $age = $previousAge + $ajaxAge;
        $image->setAvrAge($age);
        $image->setVoters();
        $em->persist($image);
        $em->flush();
        $response = new Response();
        $key = 'age' . $image->getPicId() ;
        $time = time() + (86400 * 365 * 2);
        $response->headers->setCookie(new Cookie($key, $ajaxAge, $time));

        var_dump($response->headers->getCookies());

        return $response;

    }

}
