<?php

namespace App\Controller;
use App\Entity\ImmoVente;
use App\Entity\GuinotVente;
use App\Entity\GuinotLocation;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController
{
    
    /** 
     * @Route("/accueil", name="accueil")
    */
    public function accueil()
    {
        return $this->render('default/accueil.html.twig');
    }
    
/**
     * 
     * @Route("/index", name="index")
     * 
     */
    public function index()
    {
        // Connexion à Doctrine,
        // Connexion au Repository,
        $repo = $this->getDoctrine()->getRepository(ImmoVente::class);
        $immobiliers = $repo->findAll();

        return $this->render('default/index.html.twig', [
           'controller_name' => 'DefauultController',
            // passage du contenu de $immobilier
            'immobiliers'=>$immobiliers
        ]);
    }

     /** 
     * @Route("/test", name="test")
    */
    public function test()
    {
        return $this->render('default/test.html.twig');
    }

     /** 
     * @Route("/administration", name="administration")
    */
    public function administration()
    {
        return $this->render('default/administration.html.twig');
    }

       /** 
     * @Route("/connexion", name="connexion")
    */
    public function connexion()
    {
        return $this->render('default/connexion.html.twig');
    }

     /** 
     * @Route("/nouscontacter", name="nouscontacter")
    */
    public function nouscontacter()
    {
        return $this->render('default/nouscontacter.html.twig');
    }

     /**
     * 
     * @Route("/les_ventes", name="les_ventes")
     * 
     */
    public function les_ventes()
    {
        // Connexion à Doctrine,
        // Connexion au Repository,
        $repo = $this->getDoctrine()->getRepository(GuinotVente::class);
        $GuinotVente = $repo->findAll();

        return $this->render('default/les_ventes.html.twig', [
           'controller_name' => 'DefauultController',
            // passage du contenu de $immobilier
            'GuinotVente'=>$GuinotVente
        ]);
    }

  /**
     * 
     * @Route("/les_locations", name="les_locations")
     * 
     */
    public function les_locations()
    {
        // Connexion à Doctrine,
        // Connexion au Repository,
        $repo = $this->getDoctrine()->getRepository(GuinotLocation::class);
        $GuinotLocation = $repo->findAll();

        return $this->render('default/les_locations.html.twig', [
           'controller_name' => 'DefauultController',
            // passage du contenu de $immobilier
            'GuinotLocation'=>$GuinotLocation
        ]);
    }

    /**
     * @Route("/affichage", name="affichage")
     * 
     */
	 
	public function affichage()
    {
      return $this->render('default/affichage.html.twig');
  }
    
    
}



    /** 
     * @Route("/immo/nouveau", name="immo.nouveau")
    */
    
    // Creation d'un nouveau Bien
    //public function nouveau(Request $request)
    /*{
        $entityManager = $this->entityManager;
        $immobilier = new Immobilier();

        // Demande de al creation du Formaulaire avec CreateFormBuilder
        $form = $this->createFormBuilder($immobilier)
                    ->add('titre')
                    ->add('photo')                
                    ->add('description')    

        //Utiser la Function GetForm pour voir le resultat Final
                    ->getForm();
        
        // Traitement de la requete (http) passée en parametre
        $form->handleRequest($request);

        // Test sur le Remplissage / la soummision et la validité des champs
        if ($form->isSubmitted() && $form->isValid()) {
            
            // Affectation de la Date à mon article
            $immobilier->setCreatedAt(new \DateTime());

            $entityManager->persist($immobilier);
            $entityManager->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('immo.nouveau', ['id'=>$immobilier->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }


    /**
    * @Route("/immo/{id}", name="index.affich")
    */
    // recuperation de l'identifiant
   /* public function affich($id ) 
    {
        // Appel à Doctrine & au repository
        $repo = $this->getDoctrine()->getRepository(Immobilier::class);

        //Recherche de l'article avec son identifaint
        $immobilier = $repo->find($id);
        // Passage à Twig de tableau avec des variables à utiliser
        return $this->render('home/affich.html.twig', [
            'controller_name' => 'HomeController',
            'immobilier' => $immobilier
        ]);
    }

    */