<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $productsData = $this->loadData("products");
        foreach ($productsData as $productData) {
            $product = new Product(
                $productData["name"],
                $productData["price"],
                $productData["stock"]
            );
            if ($productData["type"] !== null) {
                $specialOffer = new SpecialOffer($productData["type"]);
                $date = null !== $productData["specialOfferStart"] ? new \DateTime($productData["specialOfferStart"]) : null;
                $specialOffer->setStartDate($date);
                $product->setSpecialOffer($specialOffer);
            }
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function loadData(string $fileName): array
    {
        return json_decode(file_get_contents(__DIR__.'/'.$fileName.'.json'), true);
    }
}
