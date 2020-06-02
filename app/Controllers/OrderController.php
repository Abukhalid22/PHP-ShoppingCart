<?php

namespace Cart\Controllers;


use Slim\Router;
use Slim\Views\Twig;
use Cart\Basket\Basket;
use Cart\Models\Product;
use Cart\Models\Customer;
use Cart\Models\Address;
use psr\Http\Message\ResponseInterface as Response;
use psr\Http\Message\ServerRequestInterface as Request;


class OrderController
{

protected $basket;
protected $router;

public function __construct(Basket $basket, Router $router)
{
  $this->basket = $basket;
  $this->router = $router;
}


  public function index(Request $request, Response $response, Twig $view)
  {

  $this->basket->refresh();

  if (!$this->basket->subTotal()) {
    return $response->withRedirect($this->router->pathFor('cart.index'));
  }


    return $view->render($response, 'order/index.twig');
  }


  public function create(Request $request, Response $response, Customer $customer, Address $address)
  {
   $this->basket->refresh();


   if (!$this->basket->subTotal()) {
     return $response->withRedirect($this->router->pathFor('cart.index'));
   }

   $hash = bin2hex(random_bytes(32));

  $customer = $customer->firstOrCreate([
  'email' => $request->getParam('email'),
  'name' => $request->getParam('name'),
  ]);

  $address = $address->firstOrCreate([
    'address1' =>$request->getParam('address1'), 
    'address2' =>$request->getParam('address2'),
    'city' =>$request->getParam('city'),
    'postal_code' =>$request->getParam('postal_code'),
  ]);
  

  $order = $customer->orders()->create([
    'hash' => $hash,
    'paid' => false,
    'total' => $this->basket->subTotal() + 5,
    'address_id' => $address->id,
  ]);

  $order->products()->saveMany(
   $this->basket->all(),

   $this->getQuantities($this->basket->all())

  );




  }

  protected function getQuantities($items)
  {
    $quantities = [];

    foreach ($items as $item){
      $quantities[] = ['quantity' => $item->quantity];
    }

    return $quantities;



  }


}
