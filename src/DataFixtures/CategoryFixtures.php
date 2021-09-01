<?php

namespace App\DataFixtures;

use App\Entity\Category;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CategoryFixtures extends Fixture
{
    use DataFixturesTrait;

    public function load(ObjectManager $manager)
    {
        $categoriesData = $this->loadData("categories");
        foreach ($categoriesData as $categoryData) {
            $category = new Category($categoryData["name"]);
            $manager->persist($category);
        }

        $manager->flush();
    }
}
