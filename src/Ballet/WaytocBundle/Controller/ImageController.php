<?php

namespace Ballet\WaytocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ballet\WaytocBundle\Entity\Image;

class ImageController extends Controller
{
    public function uploadAction(Request $request)
    {
        $image = new Image();
        $form = $this->createFormBuilder($image)
            ->add('name')
            ->add('description')
            ->add('file')
            ->add('upload', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->get('security.context')->getToken()->getUser()->getId();
            $image->setUserid($userId);
            $image->upload();

            $em->persist($image);
            $em->flush();
        }

        return $this->render(
            'BalletWaytocBundle:Form:upload.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function showImagesAction()
    {
        $images = $this->getDoctrine()
            ->getRepository('BalletWaytocBundle:Image')->findAll();

        return $this->render('BalletWaytocBundle:Default:index.html.twig', array('image' => $images));
    }

    public function showImageAction($slug, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('BalletWaytocBundle:Image')->findOneBy(array('picid' => $slug));

        $this->generateUrl('post_image', array('slug' => $slug));

        return $this->render('BalletWaytocBundle:Page:item.html.twig', array('slug' => $slug, 'image' => $image));
    }
}
