<?php

namespace Gy\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GyAdminBundle:Default:index.html.twig');
    }
}
