<?php

namespace App\Controller;

use App\Entity\ReponseReclamation;
use App\Entity\Reclamation;
use App\Form\ReponseReclamationType;
use App\Form\ReclamationType;
use App\Repository\ReponseReclamationRepository;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/reponse")
 */
class ReponseReclamationController extends AbstractController
{


    /**
     * @Route("/reclamation", name="reponse_reclamation_index1", methods={"GET"})
     */
    public function index(ReclamationRepository $ReclamationRepository): Response
    {
        return $this->render('reponse_reclamation/index1.html.twig', [
            'reponse_reclamations' => $ReclamationRepository->findAll(),
        ]);
    }




    /**
     * @Route("/all", name="reponse_reclamation_index", methods={"GET"})
     */
    public function reponse(ReponseReclamationRepository $reponseReclamationRepository): Response
    {
        return $this->render('reponse_reclamation/index.html.twig', [
            'reponse_reclamations' => $reponseReclamationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/reponse", name="reponse_reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $reponseReclamation = new ReponseReclamation();
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reponseReclamation);
            $entityManager->flush();

            return $this->redirectToRoute('reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse_reclamation/new.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reponse_reclamation_show", methods={"GET"})
     */
    public function show(ReponseReclamation $reponseReclamation): Response
    {
        return $this->render('reponse_reclamation/show.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reponse_reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReponseReclamationType::class, $reponseReclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reponse_reclamation/edit.html.twig', [
            'reponse_reclamation' => $reponseReclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reponse_reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, ReponseReclamation $reponseReclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reponseReclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reponseReclamation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reponse_reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
}
