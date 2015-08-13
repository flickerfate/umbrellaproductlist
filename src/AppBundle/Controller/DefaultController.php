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
     * @return Response
     */
    public function indexAction()
    {

        $product = $this->getDoctrine()
            ->getRepository('AppBundle:Product')
            ->findAll();

        $form = $this->createForm(new ProductType(), new Product());

        return $this->render('AppBundle::main.html.twig', array(
            "products" => $product,
            "form" => $form->createView(),
             'is_error' => 0
            ));

    }

    /**
     * @Route("/save", name="form_target", methods="POST")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function saveProductAction(Request $request)
    {
        $form_type = new ProductType();
        $form_data = $request->request->get($form_type->getName());
        if(empty($form_data)){
            return new Response('Empty form');
        }

        $em = $this->getDoctrine()->getManager();

        if(isset($form_data['id']) && !empty($form_data['id']))
            $product = $em->getRepository('AppBundle:Product')->find($form_data['id']);
        else
            $product = new Product();



        $form = $this->createForm(new ProductType(), $product);
        $form->handleRequest($request);

        if($form->isValid()){
            $em->persist($product);
            $em->flush();

            return $this->redirect($this->generateUrl("homepage"));
        }

        $em->detach($product);
        $products = $em
            ->getRepository('AppBundle:Product')
            ->findAll();
        return $this->render('AppBundle::main.html.twig', array(
            "products" => $products,
            'form' => $form->createView(),
            'is_error' => 1
        ));
    }

    /**
     * @Route("/delete/{product}", name="product_delete")
     * @param Product $product
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function deleteProductAction(Product $product){

        $em = $this->getDoctrine()->getManager();
        $em->remove($product);
        $em->flush();

        return $this->redirect($this->generateUrl("homepage"));
    }


}
