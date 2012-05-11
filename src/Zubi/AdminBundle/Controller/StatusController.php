<?php

namespace Zubi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class StatusController extends Controller
{
	public function statusAction(Request $request, $id)
    {
    	$user = new User();
        $user = $this->getDoctrine()->getRepository('ZubiUserBundle:User')
                ->find($id);

        if( $user->getIdStatus() )
        	$user->setIdStatus(0);
       	else
       		$user->setIdStatus(1);

        $em = $this->getDoctrine()->getEntityManager();
        $em->flush();

        return $this->redirect($this->generateUrl('ZubiAdminBundle_list'));
    }
}