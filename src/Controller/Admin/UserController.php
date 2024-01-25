<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/user', name: 'admin_user_')]
class UserController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }

    #[Route('/{id}', name: 'details')]
    public function details(Product $product): Response
    {
        return $this->render('admin/user/details.html.twig', [
            'product' => $product,
        ]);
    }

    #[Route('/{id}/edit', name: 'edit')]
    public function edit(): Response
    {
        return $this->render('admin/user/edit.html.twig', [
            'controller_name' => 'ProductController',
        ]);
    }
}
