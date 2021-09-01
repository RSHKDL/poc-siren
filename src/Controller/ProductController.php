<?php

namespace App\Controller;

use App\Form\ProductType;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/products")
 */
class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product_list")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        $weightedProducts = $productRepository->getWeightedProductList();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'weighted_products' => $weightedProducts
        ]);
    }

    /**
     * @Route("/add", name="product_add")
     */
    public function add(Request $request, ProductRepository $productRepository): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            try {
                $productRepository->save($product, true);
                $this->addFlash("success", "Yeah!");

                return $this->redirectToRoute("product_list");
            } catch (\Throwable $throwable) {
                $message = $throwable->getMessage();
                $this->addFlash("error", "Boo! Message: $message");
            }

        }

        return $this->render('product/add.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
