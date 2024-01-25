<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Product;
use Doctrine\Persistence\ObjectManager;
use App\Repository\CategoriesRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;

class ProductFixtures extends Fixture
{
    private $faker;
    private $categoryRepository;

    public function __construct(CategoriesRepository $categoryRepository)
    {
        $this->faker = Factory::create('fr_FR');
        $this->categoryRepository = $categoryRepository;
    }

    public function load(ObjectManager $manager): void
    {
        for ($i = 0; $i < 10; $i++) {
            $this->createProduct($manager);
        }

        $manager->flush();
    }

    private function createProduct(ObjectManager $manager): void
    {
        $product = new Product();
        $product->setName($this->faker->word);
        $product->setDescription($this->faker->text);
        $product->setSlug($this->faker->slug());
        $product->setPrice($this->faker->numberBetween(10, 1000));
        $product->setStock($this->faker->numberBetween(0, 100));
        $product->setReference($this->faker->unique()->word);

        // Récupérer une catégorie aléatoire
        $categories = $this->categoryRepository->findAll();
        $category = $this->faker->randomElement($categories);
        $product->setCategories($category);

        $manager->persist($product);
    }
}
