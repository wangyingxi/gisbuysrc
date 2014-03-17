<?php

namespace Gy\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Gy\CoreBundle\Document\Product;

class ProductController extends Controller
{
    public function indexAction()
    {
    }

    public function createAction()
    {
        $product = new Product();
        $product->setName('This is product name.');

        $form = $this->createFormBuilder($product)
            ->add('name', 'text')
            ->add('price', 'number')
            ->add('save', 'submit')
            ->getForm();

        return $this->render('GyAdminBundle:Product:create.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }

}
