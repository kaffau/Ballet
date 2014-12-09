<?php

namespace Ballet\WaytocBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use Symfony\Component\HttpFoundation\Request;
use Ballet\WaytocBundle\Form\Type\RegistrationType;
use Ballet\WaytocBundle\Form\Model\Registration;
use Ballet\WaytocBundle\Entity\User;
use Symfony\Component\Validator\Constraints\DateTime;
use Symfony\Component\Security\Core\Encoder\MessageDigestPasswordEncoder;


class AccountController extends Controller
{
    public function registerAction()
    {
        $registration = new Registration();
        $form = $this->createForm(new RegistrationType(), $registration, array(
                'action' => $this->generateUrl('account_create'),
            ));

        return $this->render(
            'BalletWaytocBundle:Form:register.html.twig',
            array('form' => $form->createView())
        );
    }

    public function createAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $form = $this->createForm(new RegistrationType(), new Registration());

        $form->handleRequest($request);
        if ($form->isValid()) {
            $registration = $form->getData();


            $factory = $this->get('security.encoder_factory');
            $user = new User();
            $encoder = $factory->getEncoder($user);
            $password = $encoder->encodePassword($registration->getUser()->getPassword(), $registration->getUser()->getSalt());

            $today = new \DateTime('now');
            $registration->setUserPassword($password);
            $registration->setRegisterDate($today);
            $em->persist($registration->getUser());
            $em->flush();

            return $this->redirect($this->generateUrl('front_page'));
        }

        return $this->render(
            'BalletWaytocBundle:Form:register.html.twig',
            array('form' => $form->createView())
        );
    }

}