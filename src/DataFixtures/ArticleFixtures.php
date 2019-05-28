<?php

namespace App\DataFixtures;

use App\Entity\Article;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Faker;

class ArticleFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        for($i=0;$i<50;$i++) {
            $article = new Article();
            $faker = Faker\Factory::create('fr_FR');
            $article->setTitle(mb_strtolower($faker->sentence($nbWords = 6, $variableNbWords = true)));
            $article->setContent($faker->paragraph($nbSentences = 3, $variableNbSentences = true));
            $manager->persist($article);

            $article->setCategory($this->getReference('categorie_' . $i%6));


        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [CategoryFixtures::class];
    }
}
