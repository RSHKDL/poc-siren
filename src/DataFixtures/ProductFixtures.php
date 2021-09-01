<?php

namespace App\DataFixtures;

use App\Entity\Product;
use App\Entity\SpecialOffer;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class ProductFixtures extends Fixture
{
    use DataFixturesTrait;

    public function load(ObjectManager $manager)
    {
        $productsData = $this->loadData("products");
        foreach ($productsData as $productData) {
            $product = new Product();
            $product->setName($productData["name"]);
            $product->setPrice($productData["price"]);
            $product->setStock($productData["stock"]);
            if ($productData["type"] !== null) {
                $specialOffer = new SpecialOffer($productData["type"]);
                $date = null !== $productData["specialOfferStart"] ? new \DateTime($productData["specialOfferStart"]) : null;
                $specialOffer->setStartDate($date);
                $product->setSpecialOffer($specialOffer);
            }
            $this->setDefaultWeighting($product);
            $manager->persist($product);
        }

        $manager->flush();
    }

    private function setDefaultWeighting(Product $product): void
    {
        switch ($product) {
            case SpecialOffer::FLASH_SALES === $product->getSpecialOffer()->getType()
                && $product->getStock() > 0:
                $product->setWeighting(300);
                break;
            case SpecialOffer::SALES === $product->getSpecialOffer()->getType()
                && $product->getStock() > 0:
                $product->setWeighting(200);
                break;
            case SpecialOffer::SPECIAL_OFFER === $product->getSpecialOffer()->getType()
                && $product->getStock() > 0:
                $product->setWeighting(100);
                break;
            case 0 === $product->getStock():
                $product->setWeighting(0);
                break;
            default:
                $product->setWeighting(1);
        }
    }
}
