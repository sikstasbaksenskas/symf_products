<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProductRepository;
use App\Cart\Cart;

/**
 * @Route("/shop/cart", name="cart_")
 */
class CartController extends AbstractController
{
    private $cart;

    public function __construct(Cart $cart)
    {
        $this->cart = $cart;
    }

    /**
     * @Route("/update", name="update")
     */
    public function updateData()
    {
        $cart = $this->cart->getAllItems();

        return new JsonResponse(
            [
                'status' => 'OK',
                'products' => $cart['products'] ?? [],
                'total' => $cart['total'] ?? [
                    'price' => 0,
                    'items' => 0
                ]
            ],
            200
        );
    }

    /**
     * @Route("/list", name="list")
     */
    public function listAllItems()
    {
        $cart = $this->cart->getAllItems();

        return $this->render('cart/list.html.twig', [
            'products' => $cart['products'] ?? [],
            'total' => $cart['total'] ?? [
                'price' => 0,
                'items' => 0
            ]
        ]);
    }

    /**
     * @Route("/add", name="add")
     */
    public function addItem(ProductRepository $productRepository, Request $request)
    {
        //only for ajax
        if (!$request->isXmlHttpRequest()) {
            throw new HttpException(400, 'Only ajax requests');
        }

        //check if request exists
        if (!isset($request->request)) {
            throw new HttpException(400, 'Reqest does not exist');
        }

        //get product id from the request
        $id = $request->request->get('id');
        if (empty($id)) {
            throw new \RuntimeException('ID variable is empty');
        }

        //get product
        $product = $productRepository->find($id);
        if (empty($product)) {
            throw new \RuntimeException('There is no such product');
        }

        //add item to cart
        $result = $this->cart->addItem($product);
        return $result;

        //if something went wrong
        throw new HttpException(400, 'Something went wrong');
    }

    /**
     * @Route("/remove", name="remove")
     */
    public function removeItem(Request $request)
    {
    }
}
