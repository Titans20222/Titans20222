<?php

namespace App\Controller;


use App\Entity\Publicite;
use App\Form\PubliciteType;
use App\Repository\PubliciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/publicite")
 */
class PubliciteController extends AbstractController
{
    /**
     * @Route("/", name="publicite", methods={"GET"})
     */
    public function index(PubliciteRepository $publiciteRepository): Response
    {
        return $this->render('publicite/index.html.twig', [
            'publicites' => $publiciteRepository->findAll(),
        ]);
    }


    /**
     * @Route("/new", name="publicite_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $publicite = new Publicite();
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($publicite);
            $entityManager->flush();

            return $this->redirectToRoute('publicite', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite/new_pub.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicite_show", methods={"GET"})
     */
    public function show(Publicite $publicite): Response
    {
        return $this->render('publicite/show_pub.html.twig', [
            'publicite' => $publicite,
        ]);
    }


    /**
 * @Route("/{id}/edit", name="publicite_edit", methods={"GET", "POST"})
 */
    public function edit(Request $request, Publicite $publicite, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PubliciteType::class, $publicite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('publicite', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('publicite/edit_pub.html.twig', [
            'publicite' => $publicite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="publicite_delete", methods={"POST"})
     */
    public function delete(Request $request, Publicite $publicite, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$publicite->getId(), $request->request->get('_token'))) {
            $entityManager->remove($publicite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('publicite', [], Response::HTTP_SEE_OTHER);
    }
}
