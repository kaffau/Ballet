<?php

namespace Ballet\PostBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Ballet\PostBundle\Entity\Image;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;

class ImageController extends Controller
{
    public function uploadAction(Request $request)
    {
        $image = new Image();
        $form = $this->createFormBuilder($image)
            ->add('name')
            ->add('description')
            ->add('file', 'file', array(
                    'constraints' => new NotBlank(),
                    )
                 )
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

            $thumbnail = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,
                    $image->getWebPath(),
                    'thumb_sm'
                );
            $thumbnail = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,
                    $image->getWebPath(),
                    'thumb_md'
                );
            $thumbnail = $this->container
                ->get('liip_imagine.controller')
                ->filterAction(
                    $request,
                    $image->getWebPath(),
                    'thumb_lg'
                );
            $cacheManager = $this->container->get('liip_imagine.cache.manager');

            $image->removeUpload();

            return $this->redirect($this->generateUrl('front_page'));

        }


        return $this->render(
            'BalletPostBundle:Form:upload.html.twig',
            array(
                'form' => $form->createView()
            )
        );
    }

    public function showUserImagesAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $images = $em->getRepository('BalletPostBundle:Image')
            ->findBy(array(
                'userId' => $slug
            ));
        return $this->render(
            'BalletPostBundle:Page:images.html.twig',
            array(
                'images' => $images
            )
        );
    }

    public function deleteImageAction($slug)
    {
        $em = $this->getDoctrine()->getManager();
        $image = $em->getRepository('BalletPostBundle:Image')
            ->findOneBy(array(
                'picId' => $slug
            ));
        $image->removeThumbnail('thumb_sm');
        $image->removeThumbnail('thumb_md');
        $image->removeThumbnail('thumb_lg');
        $em->remove($image);
        $em->flush();


        return $this->redirect($this->generateUrl('images', array('slug'=> $image->getUserId())));

    }


}
