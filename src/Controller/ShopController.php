<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;

/**
 * @Route("/shop", name="shop_")
 */
class ShopController extends AbstractController
{
    /**
     * @Route("/", name="list")
     */
    public function list(ProductRepository $productRepository)
    {
        $products = $productRepository->findAll();

        return $this->render('shop/list.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/{id}", name="product")
     */
    public function product(ProductRepository $productRepository, $id)
    {
        $product = $productRepository->find($id);

        return $this->render('shop/product.html.twig', [
            'product' => $product
        ]);
    }
}
