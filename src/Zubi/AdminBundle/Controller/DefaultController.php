<?php

namespace Zubi\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class DefaultController extends Controller
{
    
    public function indexAction()
    {
        return $this->render('ZubiAdminBundle:Default:index.html.twig');
    }
}
