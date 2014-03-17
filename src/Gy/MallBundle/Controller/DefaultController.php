<?php

namespace Gy\MallBundle\Controller;

use Gy\CoreBundle\Common\ImageImagick;
use Gy\CoreBundle\Document\Product;
use Gy\CoreBundle\Common\Tool;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller {

//    public function indexAction() {
//        echo "i am in indexAction";
//        exit;
//    }

//    public function helloAction($name) {
//        $key = $this->container->getParameter('myname');
//        return new Response($key);
//        //return $this->render('GyMallBundle:Default:index.html.twig', array('name' => $name));
//    }

//    public function createAction() {
//        $product = new Product();
//        $product->setName('A Foo Bar');
//        $product->setPrice('19.99');
//        $product->setCategory(array("3923", "23938"));
//        $product->setAttributes(array("gender" => "male", "age" => 28));
//        $dm = $this->get('doctrine_mongodb')->getManager();
//        $dm->persist($product);
//        $dm->flush();
//
//        return new Response('Created product id ' . $product->getId());
//    }

    public function showAction($id) {
        $product = $this->get('doctrine_mongodb')
                ->getRepository('GyMallBundle:Product')
                ->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        // do something, like pass the $product object into a template
    }

    public function updateAction($id) {
        $dm = $this->get('doctrine_mongodb')->getManager();
        $product = $dm->getRepository('GyMallBundle:Product')->find($id);

        if (!$product) {
            throw $this->createNotFoundException('No product found for id ' . $id);
        }

        $product->setName('New product name!');
        $dm->flush();

        return $this->redirect($this->generateUrl('homepage'));
    }

//    public function translateAction(Request $request) {
    public function translateAction() {
        $request = Request::createFromGlobals();
//        var_dump($request);exit;
        echo($request->query->get('aparam'));
        exit;
        $request->setLocale('fr');
        $translated = $this->get('translator')->trans('Symfony2 is great');
//        echo $request->getLocale();exit;
        return new Response($translated);
    }

    public function t1Action() {
        $request = Request::createFromGlobals();
        echo 'current locale is : ' . $this->get('translator')->getLocale();
        exit;
    }

    public function contactAction() {
        $request = Request::createFromGlobals();
//        echo($request->getLocale());exit;
        //echo('locale is : ' . $_locale);exit;
//        $this->get('translator')->setLocale('ca_ES');
        echo($this->get('translator')->getLocale());
        exit;
    }

    public function thumbnailAction() {
        $img = new ImageImagick('/var/www/2048.jpg');
//        $img->scale('x', 300)->save('/var/www/tmp/img2.jpg', 100);
        $img->adapt(300, 300)->save('/var/www/tmp/img2.jpg', 100);
        exit;
    }

    public function uAction() {
//        return $this->render('GyMallBundle:Default:u.html.twig', array('param' => md5(microtime())));
        return $this->render('GyMallBundle:Default:u.html.twig', array('param' => Tool::genGuid()));
    }

    public function uploadAction() {
//        if(!is_dir('/var/www/gisbuysrc/tmp')) {
//            mkdir('/var/www/gisbuysrc/tmp');
//        }
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
        } else {
//            $str = "wyx";
//            echo "Upload: " . $_FILES["file"]["name"] . "<br>";
//            echo "Type: " . $_FILES["file"]["type"] . "<br>";
//            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
//            echo "Stored in: " . $_FILES["file"]["tmp_name"];
//            echo "$str";

            if (file_exists("/var/www/gisbuysrc/tmp/" . $_FILES["file"]["name"])) {
                echo $_FILES["file"]["name"] . " already exists. ";
            } else {
                move_uploaded_file($_FILES["file"]["tmp_name"], "/var/www/gisbuysrc/tmp/" . $_FILES["file"]["name"]);
                echo "Stored in: " . "/var/www/gisbuysrc/tmp/" . $_FILES["file"]["name"];
            }

            exit;
        }
    }

}
