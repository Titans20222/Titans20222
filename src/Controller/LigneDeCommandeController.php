<?php

namespace App\Controller;

use App\Entity\LigneDeCommande;
use App\Form\LigneDeCommandeType;
use App\Repository\LigneDeCommandeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Commande;
use App\Repository\CommandeRepository;
use App\Entity\LignecmdSearch;
use App\Form\LigneSearchType;






/**
 * @Route("/lignedecommande")
 */
class LigneDeCommandeController extends AbstractController
{

    /**
     * @Route("/", name="lignedecommande_index", methods={"GET"})
     */
    public function index(LigneDeCommandeRepository $lignedecommandeRepository): Response
    {
        return $this->render('ligne_de_commande/index.html.twig', [
            'lignedecommandes' => $lignedecommandeRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="lignedecommande_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $lignedecommande = new LigneDeCommande();
        $form = $this->createForm(LigneDeCommandeType::class, $lignedecommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($lignedecommande);
            $entityManager->flush();

            return $this->redirectToRoute('lignedecommande_index');
        }

        return $this->render('ligne_de_commande/new.html.twig', [
            'lignedecommande' => $lignedecommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lignedecommande_show", methods={"GET"})
     */
    public function show(LigneDeCommande $lignedecommande): Response
    {
        return $this->render('ligne_de_commande/show.html.twig', [
            'lignedecommande' => $lignedecommande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="lignedecommande_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, LigneDeCommande $lignedecommande): Response
    {
        $form = $this->createForm(LigneDeCommandeType::class, $lignedecommande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('lignedecommande_index', [
                'id' => $lignedecommande->getId(),
            ]);
        }

        return $this->render('ligne_de_commande/edit.html.twig', [
            'lignedecommande' => $lignedecommande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="lignedecommande_delete", methods={"DELETE"})
     */
    public function delete(Request $request, LigneDeCommande $lignedecommande): Response
    {
        if ($this->isCsrfTokenValid('delete'.$lignedecommande->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($lignedecommande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('lignedecommande_index');
    }
    
   /**
     * @Route("/ajax_search/comm", name="ajax_commande" ,methods={"GET"})
     * @param Request $request
     * @param LigneDeCommandetRepository $lignedecommandeRepository
     * @return Response
     */
    public function searchAction(Request $request,LigneDeCommandeRepository $lignedecommandeRepository) : Response
    {
        $em = $this->getDoctrine()->getManager();
        $requestString = $request->get('q');
        $lignedecommandes =$lignedecommandeRepository->SearchNom($requestString);
        if(!$lignedecommandes) {
            $result['lignedecommandes']['error'] = "lignedecommande non trouvée ";
        } else {
            $result['lignedecommandes'] = $this->getRealEntities($lignedecommandes);
        }
        return new Response(json_encode($result));
    }
    public function getRealEntities($lignedecommandes){
        foreach ($lignedecommandes as $lignedecommande){
            $realEntities[$lignedecommande->getId()] = [$lignedecommande->getLigne(),$lignedecommande->getNumcommande()];

        }
        return $realEntities;
    }
     /**
     * @route("/stat/com",name="stat_commande")
     */
    public function statisti( LigneDeCommandeRepository $repository, CommandeRepository $commandeRepository)
    {

        $opp=$repository->findAll();


        return $this->render("ligne_de_commande/statistique.html.twig",['Pub'=>$opp]);

    }
}
