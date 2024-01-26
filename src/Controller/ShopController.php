<?php

namespace App\Controller;

use App\Entity\Product;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/shop', name: 'shop_')]
class ShopController extends AbstractController
{
    private $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    #[Route('/', name: 'index')]
    public function index(): Response
    {
        $products = $this->productRepository->findAll();

        return $this->render('shop/index.html.twig', [
            'products' => $products,
        ]);
    }

    #[Route('/product/{id}', name: 'details')]
    public function productDetails(int $id): Response
    {
        $product = $this->productRepository->find($id);

        if (!$product) {
            throw $this->createNotFoundException('Le produit demandé n\'a pas été trouvé.');
        }

        return $this->render('shop/product_details.html.twig', [
            'product' => $product,
        ]);
    }
}
