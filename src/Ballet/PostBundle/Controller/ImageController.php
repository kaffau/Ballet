<?php

namespace Ballet\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ballet\PostBundle\Entity\Image;

class ImageController extends Controller
{
    public function uploadAction(Request $request)
    {
        $image = new Image();
        $form = $this->createFormBuilder($image)
            ->add('name')
            ->add('description')
            ->add('file', 'file')
            ->add('upload', 'submit')
            ->getForm();

        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $userId = $this->get('security.context')->getToken()->getUser()->getId();
            $image->setUserid($userId);
            $image->preUpload();
            $image->upload();

            $em->persist($image);
            $em->flush();
            return $this->redirect($this->generateUrl('front_page'));
        }

        return $this->render(
            'BalletPostBundle:Form:upload.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

}
