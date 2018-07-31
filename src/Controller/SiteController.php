<?php

namespace App\Controller;

use App\Entity\Galerie;
use App\Form\GalerieType;
use App\Repository\GalerieRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class SiteController extends Controller
{
    /**
     * @Route("/site", name="site")
     */
    public function index(GalerieRepository $repository)
    {

        $galerie = $repository->findAll();

        return $this->render('site/index.html.twig', [
            'controller_name' => 'SiteController',
            'galerie' => $galerie,
        ]);
    }

    /**
     * @Route ("/", name="home")
     */
    public function home()
    {
        return $this->render('site/home.html.twig');

    }

    /**
     * @Route ("/site/new", name="site_create")
     * @Route ("/site/{id}/edit", name="site_edit")
     */
    public function form(Galerie $galerie = null, Request $request, ObjectManager $manager)
    {

        if (!$galerie) {
            $galerie = new Galerie();
        }


        //$form = $this->createFormBuilder($galerie)
        //    ->add('title')
        //    ->add('content')
        //    ->add('image')
        //    ->getForm();

        $form = $this->createForm(GalerieType::class, $galerie);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!$galerie->getId()) {
                $galerie->setCreatedAt(new \DateTime());
            }

            $manager->persist($galerie);
            $manager->flush();

            return $this->redirectToRoute('site_show', ['id' => $galerie->getId()]);
        }

        return $this->render('site/create.html.twig', [
            'formGalerie' => $form->createView(),
            'editMode' => $galerie->getId() !== null
        ]);
    }

    /**
     * @Route ("/site/{id}", name="site_show")
     */
    public function show(Galerie $galerie)
    {

        return $this->render('site/show.html.twig', [
            'galerie' => $galerie
        ]);
    }


}
