<?php

namespace AppBundle\Controller;

use AppBundle\Form\Type\ProductType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use AppBundle\Entity\Product;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction()
    {

        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        $form = $this->createForm(new ProductType(), new Product());

        return $this->render('AppBundle::main.html.twig', array("products" => $product,"form" => $form->createView()));
//        return $this->render('default/index.html.twig', array(
//            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..'),
//        ));
    }

    /**
     * @Route("/save", name="form_target", methods="POST")
     */
    public function saveProductAction(Request $request, Product $product = null)
    {

        $product = (is_null($product))?(new Product()): $product;
        $form = $this->createForm(new ProductType(),$product);
        $form->handleRequest($request);

        if($form->isValid()){
            $em = $this->getDoctrine()->getManager();
            $em->persist($product);
            $em->flush();

            return new Response('Created product id '.$product->getId());
        }

        return new Response($form->getErrors());
    }


}
