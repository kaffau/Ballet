<?php

namespace Ballet\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
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

        $currentPage = 0;
        $itemsPerPage = 10;

        $currentPage = $currentPage + 1;
        $offset = $itemsPerPage * ($currentPage - 1);
        $images = $this->getDoctrine()
            ->getRepository('BalletPostBundle:Image')->findBy(array(),array('picId' => 'DESC'), $itemsPerPage, $offset);
        $total = count($images);
        $totalPage = ceil($total / $itemsPerPage);
        if ($request->isXmlHttpRequest()) {
            $currentPage = $request->request->get('page');
            $offset = $itemsPerPage * ($currentPage - 1);
            $images = $this->getDoctrine()
                ->getRepository('BalletPostBundle:Image')->findBy(array(),array('picId' => 'DESC'), $itemsPerPage, $offset);
            $template = $this->renderView('BalletPostBundle:Page:ajaxItem.html.twig', array( 'image' => $images) );
            $json = json_encode($template);
            $response = new Response($json);
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }
        return $this->render('BalletWaytocBundle:Default:index.html.twig', array('image' => $images));
    }

    public function showImageAction($slug)
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

        return $response;

    }

}