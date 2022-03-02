<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\LigneDeCommande;
use App\Entity\Commande;
use App\Form\LigneDeCommandeType;
use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\ProduitRepository;


/**
 * @Route("/lignedecommande")
 */
    class LignedecommandeController extends AbstractController
{
        /**
         * @Route("/", name="lignedecommande_index", methods={"GET"})
         */
    public function index(LigneDeCommandeRepository $ligneDeCommandeRepository): Response
    {
        return $this->render('lignedecommande/index.html.twig', [
            'lignedecommandes' => $ligneDeCommandeRepository->findAll(),
        ]);
    }

        /**
         * @Route("/new", name="lignedecommande_new", methods={"GET", "POST"})
         */
    public function new(SessionInterface $session,Commande $commande, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {

        $panier = $session->get("panier", []);
        foreach($panier as $id => $quantite){
            //Créer une cligne de commande pour chaque produit su panier
            $ligneDeCommande = new LigneDeCommande();
            $produit = $produitRepository->find($id);
            $ligneDeCommande->setCommande($commande);
            $ligneDeCommande->setProduit($produit);
            $ligneDeCommande->setQuantite($quantite);
            $entityManager->persist($ligneDeCommande);
            $entityManager->flush();
        }
        //Vide le panier
        $session->remove("panier");
        return $this->redirectToRoute('user_show', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);



    }
        /**
         * @Route("/{id}", name="lignedecommande_show", methods={"GET"})
         */
    public function show(LigneDeCommande $ligneDeCommande): Response
    {
        return $this->render('lignedecommande/show.html.twig', [
            'lignedecommande' => $ligneDeCommande,
        ]);
    }

        /**
         * @Route("/{id}/edit", name="lignedecommande_edit", methods={"GET", "POST"})
         */
    public function edit(Request $request, LigneDeCommande $ligneDeCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneDeCommandeType::class, $ligneDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lignedecommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignedecommande/edit.html.twig', [
            'lignedecommande' => $ligneDeCommande,
            'form' => $form,
        ]);
    }
        /**
         * @Route("/{id}", name="lignedecommande_delete", methods={"POST"})
         */
    public function delete(Request $request, LigneDeCommande $ligneDeCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneDeCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ligneDeCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lignedecommande_index', [], Response::HTTP_SEE_OTHER);
    }
   /* /**
     * @Route("/lignedecommande", name="lignedecommande")
     */
  /*  public function index(): Response
    {
        return $this->render('lignedecommande/index.html.twig', [
            'controller_name' => 'LignedecommandeController',
        ]);
    }
    */


  /*  public function index(LigneDeCommandeRepository $ligneDeCommandeRepository): Response
    {
        return $this->render('lignedecommande/index.html.twig', [
            'lignedecommandes' => $ligneDeCommandeRepository->findAll(),
        ]);
    }*/


   /* public function new(Commande $commande, ProduitRepository $produitRepository, EntityManagerInterface $entityManager): Response
    {

       // $panier = $session->get("panier", []);
        foreach ($commande as $id => $quantite) {
            //Créer une ligne de commande pour chaque produit du panier
            $ligneDeCommande = new LigneDeCommande();
            $produit = $produitRepository->find($id);
            $ligneDeCommande->setCommande($commande);
            $ligneDeCommande->setProduit($produit);
            $ligneDeCommande->setQuantite($quantite);
            $entityManager->persist($ligneDeCommande);
            $entityManager->flush();
        }

        //Vide le panier
        // $session->remove("panier");
        //return $this->redirectToRoute('user_show', ['id'=>$this->getUser()->getId()], Response::HTTP_SEE_OTHER);
        return $this->redirectToRoute('panier_index', [], Response::HTTP_SEE_OTHER);

    }
*/



  /*  public function show(LigneDeCommande $ligneDeCommande): Response
    {
        return $this->render('lignedecommande/show.html.twig', [
            'lignedecommande' => $ligneDeCommande,
        ]);
    }*/


   /* public function edit(Request $request, LigneDeCommande $ligneDeCommande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(LigneDeCommandeType::class, $ligneDeCommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('lignedecommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('lignedecommande/edit.html.twig', [
            'lignedecommande' => $ligneDeCommande,
            'form' => $form,
        ]);
    }*/

   /* public function delete(Request $request, LigneDeCommande $ligneDeCommande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ligneDeCommande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($ligneDeCommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lignedecommande_index', [], Response::HTTP_SEE_OTHER);
    }*/
}
