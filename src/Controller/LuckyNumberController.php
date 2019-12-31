<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class LuckyNumberController extends AbstractController
{
    /**
     * @Route("/luckyNumber/{yourNumber}", name="lucky_number", methods={"GET"})
     */
    public function index($yourNumber = -1)
    {
        if($yourNumber === -1)
            $yourNumber = random_int(0, 100);

        return $this->render('lucky_number.html.twig', ['number' => $yourNumber]);
    }
}