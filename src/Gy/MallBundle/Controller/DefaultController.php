<?php

namespace Gy\MallBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Gy\MallBundle\Document\Product;

class DefaultController extends Controller {

    public function indexAction($name) {
        return $this->render('GyMallBundle:Default:index.html.twig', array('name' => $name));
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

}
