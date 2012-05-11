<?php

namespace Zubi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class EdituserController extends Controller
{
    
    public function editAction(Request $request, $id)
    {
        $user = new User();
        $user = $this->getDoctrine()->getRepository('ZubiUserBundle:User')
                ->find($id);
        
        $form = $this->createFormBuilder($user)
                ->add('email', 'email', array('label' => 'E-mail'))
                ->add('kraj', 'text', array('label' => 'Kraj'))
                ->add('miasto', 'text', array('label' => 'Miasto'))
                ->add('data_ur', 'date', array('widget' => 'choice', 'label' => 'Data urodzenia  (rok / miesiąc / dzień)', 'years' => range(1900,2012), 'format' => 'yyyy-MM-dd'))
                ->getForm();

        if($request->getMethod() == 'POST')
        {
            $form->bindRequest($request);

            if($form->isValid())
            {
                
                $em = $this->getDoctrine()->getEntityManager();
                $em->flush();


                return $this->redirect($this->generateUrl('ZubiAdminBundle_list'));
            }
        }
        
        
        return $this->render('ZubiAdminBundle:Default:edit.html.twig', 
                array('form' => $form->createView(), 'id' => $id));
    }
}