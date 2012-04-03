<?php

namespace Zubi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class EdituserController extends Controller
{
    
    public function editAction(Request $request)
    {
        $user = new User();
        $user = $this->get('security.context')->getToken()->getUser();
        
        $form = $this->createFormBuilder($user)
                ->add('email', 'email', array('label' => 'E-mail'))
                ->add('kraj', 'text', array('label' => 'Kraj'))
                ->add('miasto', 'text', array('label' => 'Miasto'))
                ->add('data_ur', 'date', array('widget' => 'single_text', 'label' => 'Data urodzenia  (rok / miesiąc / dzień)', 'years' => range(1900,2012), 'format' => 'yyyy-MM-dd'))
                ->getForm();

        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);

            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();


                return $this->redirect($this->generateUrl('ZubiUserBundle_homepage'));
            }
        }
        
        
        return $this->render('ZubiUserBundle:Default:edit.html.twig', 
                array('form' => $form->createView()));
    }
}