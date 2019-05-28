<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use app\Entity\Category;
use phpDocumentor\Reflection\Types\Self_;

class CategoryFixtures extends Fixture
{
    const CATEGORIE = [
        'PHP',
        'JAVA',
        'Javascript',
        'DevOps',
        'Ruby',
        'Python'
    ];

    public function load(ObjectManager $manager)
    {
        foreach (self::CATEGORIE as $key => $categoryName) {
            $category = new Category();
            $category->setName($categoryName);
            $manager->persist($category);
            $this->addReference('categorie_'. $key, $category);
        }
       $manager->flush();
    }
}
