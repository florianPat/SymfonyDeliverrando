<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends DefaultLayoutBaseController
{
    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
