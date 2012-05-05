<?php

namespace Zubi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Zubi\UserBundle\Entity\User;
use Symfony\Component\HttpFoundation\Request;


class ListController extends Controller
{
    
    public function listAction(Request $request)
    {

        $users = $this->getDoctrine()->getRepository('ZubiUserBundle:User')
        		->findAll();

        return $this->render('ZubiAdminBundle:Default:list.html.twig', array('users' => $users));

    }
}