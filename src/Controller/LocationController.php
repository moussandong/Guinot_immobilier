<?php

namespace App\Controller;

use App\Entity\Location;
use App\Repository\LocationRepository;

use App\Entity\Categorie;
use App\Entity\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;

class LocationController extends AbstractController
{ 
    /**
     * @param LocationRepository $locationrepository
     * @param EntityManageInterface $em
     * @return void
     */
    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    
    /**
     * Administration de Biens locatifs
     * @param
     * @Route("/admin/location", name="location_admin.index")
     * @param
     */
    public function admin(LocationRepository $locarepo, PaginatorInterface $paginator, Request $request)
    {
    // Connexion à ma BD
       // $repo = $this->getDoctrine()->getRepository(Location::class);
        $locations = $paginator->paginate(
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            25 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('location/admin.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }

    /**
     * Affichage aux users de Biens en location
     * Affichage pour les visiteurs // Different de l'affichage pour les Admins
     * @param LocationRepository $locarepo,
     * @param PaginatorInterface $paginator,
     * @param Request $request,
     * @Route("/location", name="location.index")
     * @param
     */
    public function index(LocationRepository $locarepo, PaginatorInterface $paginator, Request $request)
    {
        $locations = $paginator->paginate( //utilisation du Paginator pour la pagination des pages
            $locarepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            20 /*limit per page*/
         );
       // Appel de la page pour affichage
        return $this->render('location/index.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }


/**
     * Affichage aux users de terrains en Location
     * @param LocationRepository $locationrepo,
     * @param Request $request,
     * @Route("/location/terrains", name="location.terrains.index")
     * @param
     */
    public function listTerrains(LocationRepository $locationrepo, Request $request)
    {
        $locations= $locationrepo->findByCatTerrains();
       // Appel de la page pour affichage
        return $this->render('location/location_categorie.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }

/**
     * Affichage aux users de la liste des Appartements en Location
     * @param LocationRepository $locationrepo,
     * @param Request $request,
     * @Route("/location/appartements", name="location.appartements.index")
     * @param
     */
    public function lisApprtements(LocationRepository $locationrepo, Request $request)
    {
        $locations= $locationrepo->findByCatAppartements();
       // Appel de la page pour affichage
        return $this->render('location/location_categorie.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }

/**
     * Affichage aux users de la liste des MAisons en Location
     * @param LocationRepository $locationrepo,
     * @param Request $request,
     * @Route("/location/maisons", name="location.maisons.index")
     * @param
     */
    public function listMaisons(LocationRepository $locationrepo, Request $request)
    {
        $locations= $locationrepo->findByCatMaisons();
       // Appel de la page pour affichage
        return $this->render('location/location_categorie.html.twig', [
            // passage du contenu de $location
            'locations'=>$locations
        ]);
    }


    /** 
     * Creation de Bien en Admin
     * @param Request $request
     * @Route("admin/location/nouveau", name="location.nouveau.admin")
     * @param Response
    */
    // Creation de Location
    public function nouvellocation(Request $request): Response
    {
        $location = new Location();

    // Creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($location)
                    ->add('denomination')
                    ->add('categorie', EntityType::class, [
                        // looks for choices from this entity
                            'class' => Categorie::class,
                        // uses the User.username property as the visible option string
                        'choice_label' => 'titre'])                
                    ->add('photo')   
                    ->add('description')
                    ->add('surface')                
                    ->add('type', ChoiceType::class, array(
                            'choices' => array(
                                'F1'=> 'F1',
                                'F2'=> 'F2',
                                'F3'=> 'F3',
                                'F4'=> 'F4',
                                'F5'=> 'F5',
                                'F6'=> 'F6',
                            )))
    
                    ->add('chambre', ChoiceType::class, array(
                        'choices' => array(
                            '1'=> '1',
                            '2'=> '2',
                            '3'=> '3',
                            '4'=> '4',
                            '5'=> '5',
                            '6'=> '6',
                        )))
                    ->add('etage')                
                    ->add('prix')    
                    ->add('adresse')
                    ->add('cp')                
                    ->add('ville')    
                    ->add('pays')      
                    ->add('accessibility', ChoiceType::class, array(
                        'choices' => array(
                            'Oui'=> 'oui',
                        )))          

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Affectation de la Date à mon article
            $location->setCreatedAt(new \DateTime());

            $this->em->persist($location);
            $this->em->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('location.nouveau.admin', ['id'=>$location->getId()]);
        }
                     
        //Passage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('location/nouveau.html.twig', [
            'location'=>$location,
            'formlocation' => $form->createView()
        ]);
    }

    /** 
     * // Edition de Biens locatifs 
     * @param Request $request
     * @param Location $location
     * @Route("admin/loca/{id}/edit", name="location.edition", methods="GET|POST")
     * @param void
    */
    public function edit($id, location $location, Request $request)
    {
        // Demande de al creation du Formaulaire avec CreateFormBuilder
                $form = $this->createFormBuilder($location)
                ->add('denomination')
                ->add('categorie', EntityType::class, [
                    // looks for choices from this entity
                        'class' => Categorie::class,
                    // uses the User.username property as the visible option string
                    'choice_label' => 'titre'])                
                ->add('photo')   
                ->add('description')
                ->add('surface')                
                ->add('type', ChoiceType::class, array(
                    'choices' => array(
                        'F1'=> 'F1',
                        'F2'=> 'F2',
                        'F3'=> 'F3',
                        'F4'=> 'F4',
                        'F5'=> 'F5',
                        'F5'=> 'F6',
                    )))    
                ->add('chambre')
                ->add('etage')                
                ->add('prix')    
                ->add('adresse')
                ->add('cp')                
                ->add('ville')    
                ->add('pays')      
                ->add('accessibility')  

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
        // $entityManager = $this->getDoctrine()->getManager();
        // $this->em->persist($location); // Pas besoin de faire de Persistance ici, L'objet vient de la Base de données
           $this->em->flush();
            

        //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('location_admin.index');
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('location/nouveau.html.twig', [
            'formlocation' => $form->createView()
        ]);
    }
    
    /**
     * Affiche en details d'un Bien locatif
     * @param $id
     * @param LocationRepository $immorepo
     * @Route("/location/{id}", name="location.affich")
     * @param 
    */
    // recuperation de l'identifiant
    public function affichage($id, LocationRepository $locarepo ) 
    {
        // Appel à Doctrine & au repository
        // $repo = $this->getDoctrine()->getRepository(Location::class);

        //Recherche de l'article avec son identifaint
        $location = $locarepo->find($id);
        // Passage à Twig de tableau avec des variables à utiliser
        return $this->render('location/affich.html.twig', [
            'controller_name' => 'LocationController',
            'location' => $location
        ]);
    }
    
    /**
     * Suupression d'un Bien locatif
     * @Route("admin/loca/{id}/delete", name="loca.delete", methods={"DELETE"})
     */
    // recuperation de l'identifiant
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }
        return $this->redirectToRoute('location_admin.index');
    }

}
