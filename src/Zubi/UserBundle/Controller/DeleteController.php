<?php

namespace Zubi\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;

class DeleteController extends Controller
{
    
    public function deleteAction(Request $request)
    {
    	$user = new User();
    	$user = $this->get('security.context')->getToken()->getUser();

        $this->get('request')->getSession()->invalidate();
        $this->get("security.context")->setToken(null);

    	$em = $this->getDoctrine()->getEntityManager();
    	$em->remove($user);
    	$em->flush();

        return $this->redirect(($this->generateUrl('ZubiIndexBundle_homepage')));
    }
}