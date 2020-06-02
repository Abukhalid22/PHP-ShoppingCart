<?php


namespace Cart\Controllers;


use Slim\Router;
use Cart\Models\Product;
use Slim\Views\Twig;
use psr\Http\Message\ResponseInterface as Response;
use psr\Http\Message\ServerRequestInterface as Request;


class ProductController
{
    
    Public function get($slug, Request $request, Response $response, Twig $view, Router $router, Product $product )
    {


        $product = $product->where('slug', $slug)->first();

        if (!$product){
            return $response->withRedirect($router->pathfor('home'));
        }

        return $view->render($response, 'products/product.twig', [
            'product' => $product,
        ]);
    }
}