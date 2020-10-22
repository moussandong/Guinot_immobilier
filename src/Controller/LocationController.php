<?php

namespace App\Controller;

use App\Entity\Location;
use App\Entity\Immobilier;
use App\Entity\ImmoVente;

use App\Repository\ImmobilierRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;


class LocationController extends AbstractController
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
     * @param
     * @Route("/admin/location", name="location_admin.index")
     * @param
     */
    public function index(ImmobilierRepository $immorepo, PaginatorInterface $paginator, Request $request)
    {
        // Connexion à ma BD
        // $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $immobiliers = $paginator->paginate(
            $immorepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
        );

        // Appel de la page pour affichage
        return $this->render('location/admin.html.twig', [
            // passage du contenu de $immobilier
            'immobiliers' => $immobiliers
        ]);
    }
}
