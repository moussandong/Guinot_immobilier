<?php

namespace App\Controller;

use App\Entity\Immobilier;
use App\Entity\ImmoVente;
use App\Repository\ImmobilierRepository;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityManager;
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
     * @param
     * @Route("/", name="index")
     * @Route("/accueil", name="index.accueil")
     */
    public function index(ImmobilierRepository $immorepo, PaginatorInterface $paginator, Request $request)
    {
    // Connexion à ma BD
       // $repo = $this->getDoctrine()->getRepository(Immobilier::class);
        $immobiliers = $paginator->paginate(
            $immorepo->findAll(),
            $request->query->getInt('page', 1), /*page number*/
            3 /*limit per page*/
         );

       // Appel de la page pour affichage
        return $this->render('home/index.html.twig', [
            // passage du contenu de $immobilier
            'immobiliers'=>$immobiliers
        ]);
    }

    /** 
     * @param Request $request
     * @Route("/immo/nouveau", name="immo.nouveau")
     * @param Response
    */
    
    // Creation d'un nouveau Bien
    public function nouveauBien(Request $request): Response
    {
        $immobilier = new Immobilier();

    // Creation du Formaulaire avec CreateFormBuilder
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

            $this->em->persist($immobilier);
            $this->em->flush();

            //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('immo.nouveau', ['id'=>$immobilier->getId()]);
        }
                     
        //Passage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'immobilier'=>$immobilier,
            'formImmobilier' => $form->createView()
        ]);
    }


    /** 
     * @param Request $request
     * @param Immobilier $immobilier
     * @Route("/immo/{id}/edit", name="immo.edition", methods="GET|POST")
     * @param void
    */
    
    // Edition d'un Bien
    public function edit($id, Immobilier $immobilier, Request $request)
    {
        // $immobilier =  $entityManager->getRepository(Immobilier::class)->find($id);

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
            
        // $entityManager = $this->getDoctrine()->getManager();
        // $this->em->persist($immobilier); // Pas besoin de faire de Persistance ici, L'objet vient de la Base de données
           $this->em->flush();
            

        //Enregistrement et Retour sur la page de l'article
            return $this->redirectToRoute('index.affich', ['id'=>$immobilier->getId()]);
        }
         
            
        //aPassage à Twig des Variable à afficher avec lmethode CreateView
        return $this->render('home/nouveau.html.twig', [
            'formImmobilier' => $form->createView()
        ]);
    }


    /**
     * @param $id
     * @param ImmobilierRepository $immorepo
     * @Route("/immo/{id}", name="index.affich")
     * @param 
    */
    // recuperation de l'identifiant
    public function affichage($id, ImmobilierRepository $immorepo ) 
    {
        // Appel à Doctrine & au repository
        // $repo = $this->getDoctrine()->getRepository(Immobilier::class);

        //Recherche de l'article avec son identifaint
        $immobilier = $immorepo->find($id);
        // Passage à Twig de tableau avec des variables à utiliser
        return $this->render('home/affich.html.twig', [
            'controller_name' => 'HomeController',
            'immobilier' => $immobilier
        ]);
    }


    /**
     * @Route("/immo/{id}/edit", name="index.suppression", methods={"DELETE"})
     */
    /*public function delete(Request $request, Immobilier $immobilier ): Response
    {
        {
           /* $this->$em->getDoctrine()->getManager();
            $this->$em->remove($immobilier);
            $em->flush(); *//*
            if ($this->isCsrfTokenValid('delete'.$immobilier->getId(), $request->request->get('_token'))) {
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->remove($immobilier);
                $entityManager->flush();

            }
        }

        return new Response ('Produit supprimé');
        //return $this->redirectToRoute('immo.nouveau');
    }
    */
    
    /**
     * @Route("immo/{id}/delete", name="immo_delete", methods={"DELETE"})
     */


    public function delete(Request $request, Immobilier $immobilier): Response
    {
        if ($this->isCsrfTokenValid('delete'.$immobilier->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($immobilier);
            $entityManager->flush();
        }
        return $this->redirectToRoute('index.accueil');
    }
    /**
     * @param
     * @Route("/apropos", name="apropos")
     * @param
    */
    public function apropos()
    {
        return $this->render('home/apropos.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @param
     * @Route("/page", name="index.page")
     * @param
    */
    public function page()
    {
        return $this->render('home/page.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

}
