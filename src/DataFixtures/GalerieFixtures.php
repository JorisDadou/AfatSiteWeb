<?php

namespace App\DataFixtures;

use App\Entity\Galerie;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

class GalerieFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        for ($i = 1; $i <= 10; $i++) {
            $galerie = new Galerie();
            $galerie->setTitle("Titre de l'image n°$i")
                ->setContent("<p>Contenu de l'article n°$i</p>")
                ->setImage("http://placehold.it/350x150")
                ->setCreatedAt(new \DateTime());

            $manager->persist($galerie);
        }

        $manager->flush();
    }
}
