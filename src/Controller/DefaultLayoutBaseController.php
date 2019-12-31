<?php

namespace App\Controller;

use App\Navigation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class DefaultLayoutBaseController extends AbstractController
{
    /**
     * @var array
     */
    private $navigations;

    public function __construct()
    {
        $this->navigations = [];

        array_push($this->navigations, new Navigation('Home', 'index'));
    }

    protected function render(string $view, array $parameters = [], Response $response = null): Response
    {
        $parameters['navigation'] = $this->navigations;
        return parent::render($view, $parameters, $response);
    }
}