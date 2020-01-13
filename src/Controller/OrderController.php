<?php

namespace App\Controller;

use App\Entity\Product;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class OrderController extends DefaultLayoutBaseController
{
    /**
     * @Route("/order/{product}", name="order")
     *
     * IsGranted("ROLE_CUSTOMER")
     */
    public function order(Product $product): Response
    {
        return new Response('You ordered ' . $product->getName());
    }
}