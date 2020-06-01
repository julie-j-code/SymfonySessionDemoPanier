<?php

namespace App\Controller;

use App\Repository\ProductRepository;
//puisque j'ai externalisé la logique de gestion du panier à CartService...
//use Symfony\Component\HttpFoundation\Request;
//use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Service\Cart\CartService;

class CartController extends AbstractController
{
    /**
     * @Route("/panier", name="cart_index")
     */
    
    public function index(CartService $cartService)    
    {
        $panierWithData = $cartService->getFullCart();

        $total = $cartService->getTotal();

        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/panier/remove/{id}", name="cart_remove")
     */

     public function remove($id, CartService $cartService){

        $cartService->remove($id);

       
        return $this->redirectToRoute("cart_index");
     }

    /**
     * @Route("/panier/add/{id}", name="cart_add")
     */

    public function add($id, CartService $cartService){  

        $cartService->add($id);       

        // dd($session->get('panier'));

        return $this->redirectToRoute("cart_index");
    }
}
