<?php

namespace Zubi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;


class DeleteController extends Controller
{
    
    public function deleteAction()
    {
    	$user = new User();
    	$user = $this->get('security.context')->getToken()->getUser();
    	
    	return $this->redirect(($this->generateUrl('ZubiUserBundle_logout')));

    	$em = $this->getDoctrine()->getEntityManager();
    	$em->remove($user);
    	$em->flush();
    }
}