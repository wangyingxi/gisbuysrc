<?php

namespace Gy\MallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Gy\MallBundle\Document\Product;

class DefaultController extends Controller {

    public function indexAction() {
        echo "i am in indexAction";exit;
    }

    public function helloAction($name) {
        $key = $this->container->getParameter('myname');
        return new Response($key);
        //return $this->render('GyMallBundle:Default:index.html.twig', array('name' => $name));
    }

    public function createAction() {
        $product = new Product();
        $product->setName('A Foo Bar');
        $product->setPrice('19.99');
        $product->setCategory(array("3923", "23938"));
        $product->setAttributes(array("gender" => "male", "age" => 28));
        $dm = $this->get('doctrine_mongodb')->getManager();
        $dm->persist($product);
        $dm->flush();

        return new Response('Created product id ' . $product->getId());
    }

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
        echo($request->query->get('aparam'));exit;
        $request->setLocale('fr');
        $translated = $this->get('translator')->trans('Symfony2 is great');
//        echo $request->getLocale();exit;
        return new Response($translated);
    }

    public function t1Action($_locale) {
        $request = Request::createFromGlobals();
//        echo($request->query->get('name'));exit;
        echo($_locale);exit;
    }
    
    public function contactAction($_locale) {
        $request = Request::createFromGlobals();
//        echo($request->getLocale());exit;
        //echo('locale is : ' . $_locale);exit;
//        $this->get('translator')->setLocale('ca_ES');
        echo($this->get('translator')->getLocale());exit;
    }
}
