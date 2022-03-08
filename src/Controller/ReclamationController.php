<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Swift_Mailer;

/**
 * @Route("/reclamation")
 */
class ReclamationController extends AbstractController
{




    /**
     * @Route("/", name="reclamation_index")
     */
    public function index(Request $request,ReclamationRepository $reclamationRepository,PaginatorInterface $paginator)
    {
        $repo=$this->getDoctrine()->getRepository(Reclamation::class);
        $reclamation= $paginator->paginate(
            $reclamation=$reclamationRepository->findAll(), // Requête contenant les données à paginer (ici nos articles)kkkk
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            4 // Nombre de résultats par page
        );
        return $this->render('reclamation/index.html.twig',[
            'reclamations'=>$reclamation
        ]);
    }


    /**
     * @Route("/new", name="reclamation_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager,Swift_Mailer $mailer
    ): Response
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($reclamation);
             $this->mail($mailer);
            $entityManager->flush();
            $this->addFlash('success','reclamation ajoute avec succes');

            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/new.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_show", methods={"GET"})
     */
    public function show(Reclamation $reclamation): Response
    {
        return $this->render('reclamation/show.html.twig', [
            'reclamation' => $reclamation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="reclamation_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();
            $this->addFlash('success','reclamation mise a jour avec succes');


            return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reclamation/edit.html.twig', [
            'reclamation' => $reclamation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reclamation_delete", methods={"POST"})
     */
    public function delete(Request $request, Reclamation $reclamation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reclamation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($reclamation);
            $entityManager->flush();
            $this->addFlash('success','reclamation supprimer avec succes');

        }

        return $this->redirectToRoute('reclamation_index', [], Response::HTTP_SEE_OTHER);
    }
    public function mail( \Swift_Mailer $mailer)
    {
        $message = (new \Swift_Message('Vous Avez Ajouter une RECLAMATION!!  '))
            ->setFrom('bazdeh.mustapha@esprit.tn')
            ->setTo('bazdehmustapha3@gmail.com')
            ->setBody(
                $this->renderView(
                // templates/emails/registration.html.twig
                    'emails/registration.html.twig',

                ),
                'text/html'

            );
        $mailer->send($message);
        // you can remove the following code if you don't define a text version for your emails
        //->addPart(
        //$this->renderView(
        // templates/emails/registration.txt.twig
        // 'emails/registration.txt.twig',

        //),
        // 'text/plain'

        ;

        $mailer->send($message);
    }
}
