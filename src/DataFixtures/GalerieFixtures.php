<?php

namespace App\DataFixtures;


use App\Entity\Comment;
use Faker;
use App\Entity\Category;
use App\Entity\Galerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GalerieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {

        $faker = Faker\Factory::create('fr_FR');

        //Créer 3 categories fakées
        for ($i = 1; $i <= 3; $i++) {
            $category = new Category();
            $category->setTitle($faker->sentence())
                ->setDescription($faker->paragraph());


            $manager->persist($category);

            //Créer entre 4 et 6 Articles
            for ($j = 1; $j <= mt_rand(4, 6); $j++) {

                $content = '<p>' . join($faker->paragraphs(5), '</p><p>') . '</p>';

                $galerie = new Galerie();
                $galerie->setTitle($faker->sentence())
                    ->setContent($content)
                    ->setImage($faker->imageUrl())
                    ->setCreatedAt($faker->dateTimeBetween('-6 months'))
                    ->setCategory($category);

                $manager->persist($galerie);

                for ($k = 1; $k <= mt_rand(4, 10); $k++) {
                    $comment = new Comment();

                    $content = '<p>' . join($faker->paragraphs(2), '</p><p>') . '</p>';

                    $now = new \DateTime();
                    $interval = $now->diff($galerie->getCreatedAt());
                    $days = $interval->days;
                    $minimum = '-' . $days . 'days';

                    $comment->setAuthor($faker->name)
                        ->setContent($content)
                        ->setCreatedAt($faker->dateTimeBetween($minimum))
                        ->setGalerie($galerie);

                    $manager->persist($comment);

                }
            }
        }

        $manager->flush();
    }
}
