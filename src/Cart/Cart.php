<?php

namespace App\Cart;

use Symfony\Component\HttpFoundation\Session\Attribute\NamespacedAttributeBag;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\Storage\NativeSessionStorage;
use Symfony\Component\HttpFoundation\JsonResponse;

class Cart
{
    /**
     * get all items
     */
    public function getAllItems()
    {
        $session = new Session(new NativeSessionStorage(), new NamespacedAttributeBag());
        //$session->clear();
        //get all products and total price form cart
        return $session->get('cart', []);
    }

    /**
     * add item to cart
     */
    public function addItem($product)
    {
        $session = new Session(new NativeSessionStorage(), new NamespacedAttributeBag());

        //get product by name
        $stored_product = $session->get('cart/products/' . $product->getId(), []);

        //total cart price
        $total = $session->get('cart/total', []);

        //if there is no such product - add one
        if ($stored_product == []) {
            $new_product = [
                'quantity' => 1,
                'price' => $product->getPrice(),
                'name'  => $product->getTitle()
            ];
            $session->set('cart/products/' . $product->getId(), $new_product);
        } else {
            //if product exists - increase quantity and update price
            $quantity = $stored_product['quantity'] + 1;
            $new_product = [
                'quantity' => $quantity,
                'price' => $product->getPrice() * $quantity,
                'name'  => $product->getTitle()
            ];
            $session->set('cart/products/' . $product->getId(), $new_product);
        }

        //total price update
        if ($total == []) {
            $new_total = [
                'items' => 1,
                'price' => $product->getPrice()
            ];
            $session->set('cart/total', $new_total);
        } else {
            $new_total = [
                'items' => $total['items'] + 1,
                'price' => $total['price'] + $product->getPrice()
            ];
            $session->set('cart/total', $new_total);
        }

        //add item to cart
        return new JsonResponse(
            [
                'status' => 'OK',
                'message' => 'Item has been added successfuly'
            ],
            200
        );
    }

    /**
     * remove item from cart
     */
    public function removeItem($id)
    {
    }
}
