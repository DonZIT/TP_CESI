<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Images;
use App\DataFixtures\ProductFixtures;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ImagesFixtures extends Fixture implements DependentFixtureInterface
{
    private $faker;

    public function __construct()
    {
        $this->faker = Factory::create('fr_FR');
    }

    public function load(ObjectManager $manager): void
    {
        for ($img = 1; $img <= 100; $img++) {
            $image = new Images();
            $image->setName($this->faker->image(null, 640, 480));
            $product = $this->getReference('prod-' . rand(0, 9));
            $image->setProducts($product);
            $manager->persist($image);
        }

        $manager->flush();
    }

    // Fixtures to run before ImagesFixtures
    public function getDependencies(): array
    {
        return [
            ProductFixtures::class
        ];
    }
}
