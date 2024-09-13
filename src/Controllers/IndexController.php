<?php

namespace App\Controllers;

use App\Classes\View;
use DI\Attribute\Inject;
use Psr\Http\Message\ResponseInterface;
use Slim\Psr7\Request;

class IndexController
{
    #[Inject]
    protected View $view;

    public function __invoke(Request $request): ResponseInterface
    {
        return $this->view->render('index.twig');
    }
}
