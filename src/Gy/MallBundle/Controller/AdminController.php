<?php

namespace Gy\MallBundle\Controller;

use Gy\MallBundle\Common\ImageImagick;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Gy\MallBundle\Document\Product;

class AdminController extends Controller {
    public function indexAction() {
        return $this->render('GyMallBundle:Admin:newEmptyPHPWebPage.php', array('name' => $name));
    }
    public function loginAction() {
        
    }
}
