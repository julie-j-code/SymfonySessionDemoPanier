<?php

namespace App\Service\Cart;

use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService{

    protected $session;

    public function __construct(SessionInterface $session, ProductRepository $productRepository){
        $this->session = $session;
        $this->productRepository = $productRepository;
    }

    public function add(int $id){
        // attention, en recopiant le code initialement placé dans le controller pour créer ce service        
        // je n'ai plus accès directement à $session mais à une propriété protégée qui contient ma sesion
        $panier = $this->session->get('panier', []);       
        
        if(!empty($panier[$id])){
            $panier[$id]++;
        }else{
            $panier[$id] = 1;        
        }

        $this->session->set('panier', $panier);
        
    }

    public function remove(int $id){
        $panier = $this->session->get('panier', []);

        if(!empty($panier[$id])){
           unset($panier[$id]);
        }

        $this->session->set('panier', $panier);

    }

public function getFullCart():array {
        $panier = $this->session->get('panier', []);
        $panierWithData = [];
        foreach($panier as $id => $quantity){
            $panierWithData [] = [
                'product' => $this->productRepository->find($id),
                'quantity' => $quantity
            ];

}
        return $panierWithData;

    }

    public function getTotal():float {
        $total = 0;
        // $panierWithData = $this->getFullCart();
        foreach ($this->getFullCart() as $item) {
            $totalItem = $item['product']-> getPrice() * $item['quantity'] ;
            $total +=$totalItem;
        }
        return $total;

    }
}

