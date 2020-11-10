<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Form\SearchForm;

use App\Repository\LocationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

class HomeController extends AbstractController
{
    /**
     * @param ImmobilierRepository $immobilierrepository
     * @param EntityManageInterface $em
     * @return void
     */
 
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    

    /**
     * Affichage aux users de Biens en location à partir de la UNE du site
     * Affichage pour les visiteurs // Different de l'affichage pour les Admins
     * @param LocationRepository $locarepo,
     * @param PaginatorInterface $paginator,
     * @param Request $request,
     * @Route("/", name="location.index")     * @Route("/", name="index")
     * @Route("/accueil", name="index.accueil")     * @param
     */
    public function index(LocationRepository $locarepo, PaginatorInterface $paginator, Request $request)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);
        $locations = $paginator->paginate( //utilisation du Paginator pour la pagination des pages
            $locarepo->findLocaRech($data),
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
         );
       // Appel de la page pour affichage
        return $this->render('home/index.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations,
            'form'=> $form->createView(),
        ]);
    }


    /**
     * Affichage de la Page A propos
     * @param LocationRepository $locationRepository, 
     * @param Request $reques
     * @Route("/about", name="about.index")
     */
    public function aboutUs()
    {
       // Appel de la page pour affichage
        return $this->render('home/about.html.twig');
    }



}
