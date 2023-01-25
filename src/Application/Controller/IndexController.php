<?php

declare(strict_types=1);

namespace App\Application\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index_index')]
    public function index(): RedirectResponse
    {
        return $this->redirect('/admin');
    }
}
