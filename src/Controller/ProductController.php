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
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @Route("/", name="product_list")
     */
    public function index(): Response
    {
        $products = $this->productRepository->findAll();
        $weightedProducts = $this->productRepository->getWeightedProductList();

        return $this->render('product/index.html.twig', [
            'products' => $products,
            'weighted_products' => $weightedProducts
        ]);
    }

    /**
     * @Route("/add", name="product_add")
     */
    public function add(Request $request): Response
    {
        $form = $this->createForm(ProductType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            try {
                $this->productRepository->save($product, true);
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

    /**
     * @Route("/edit/{uuid}", name="product_edit")
     */
    public function edit(Request $request, string $uuid): Response
    {
        $product = $this->productRepository->findOneBy(['uuid' => $uuid]);

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $product = $form->getData();

            try {
                $this->productRepository->save($product, true);
                $this->addFlash("success", "Yeah!");

                return $this->redirectToRoute("product_list");
            } catch (\Throwable $throwable) {
                $message = $throwable->getMessage();
                $this->addFlash("error", "Boo! Message: $message");
            }

        }

        return $this->render('product/edit.html.twig', [
            'form' => $form->createView(),
            'product' => $product
        ]);
    }
}
