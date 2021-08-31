<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
