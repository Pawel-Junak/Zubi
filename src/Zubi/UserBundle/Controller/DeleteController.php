<?php

namespace Zubi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{
    
    public function deleteAction(Request $request, $id)
    {
    	$user = new User();
    	$user = $this->get('security.context')->getToken()->getUser();

        if($id == $user->getId())
        {
            $this->get('request')->getSession()->invalidate();
            $this->get("security.context")->setToken(null);

        	$em = $this->getDoctrine()->getEntityManager();
        	$em->remove($user);
    	    $em->flush();

            return $this->redirect(($this->generateUrl('ZubiIndexBundle_homepage')));
        }
        else
        {
            $user = $this->getDoctrine()->getRepository('ZubiUserBundle:User')
                ->find($id);

            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($user);
            $em->flush();

            return $this->redirect(($this->generateUrl('ZubiAdminBundle_list')));
        }
    }
}