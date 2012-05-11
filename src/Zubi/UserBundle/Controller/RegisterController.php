<?php

namespace Zubi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class RegisterController extends Controller
{
    
    public function registerAction(Request $request)
    {
        $user = new User();

        
        $form = $this->createFormBuilder($user)
                ->add('email', 'email', array('label' => 'E-mail'))
                ->add('haslo', 'password', array('label' => 'Hasło'))
                ->add('kraj', 'text', array('label' => 'Kraj'))
                ->add('miasto', 'text', array('label' => 'Miasto'))
                ->add('data_ur', 'date', array( 'widget' => 'choice', 'label' => 'Data urodzenia', 'years' => range(1900,2012), 'format' => 'yyyy-MM-dd'))
                ->getForm();

// 'attr' => array('data-calendar' => '{}'),

        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);

            if($form->isValid())
            {
                $user->setOsobaPrezentacja(1);
                $user->setKrajPrezentacja(1);
                $user->setMiastoPrezentacja(1);
                $user->setData_UrPrezentacja(1);
                $user->setIdStatus(0);
                
                $factory = $this->get('security.encoder_factory');
                $encoder = $factory->getEncoder($user);
                $password = $encoder->encodePassword($user->getHaslo(), $user->getSalt());
                $user->setHaslo($password);

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($user);
                $em->flush();


                return $this->redirect($this->generateUrl('ZubiUserBundle_homepage'));
            }
        }
        
        
        return $this->render('ZubiUserBundle:Default:register.html.twig', 
                array('form' => $form->createView()));
    }
}