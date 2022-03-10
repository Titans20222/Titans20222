<?php

namespace App\Controller;

use App\Entity\LigneDeCommande;
use App\Entity\Commande;
use App\Form\LigneDeCommandeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\CommandeRepository;
use App\Form\CommandeType;
use Symfony\Component\HttpFoundation\Request;
use App\Repository\ProduitRepository;
use App\Repository\LigneDeCommandeRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;


/**
 * @Route("/commande")
 */
class CommandeController extends AbstractController
{
    /**
     * @Route("/", name="commande_index", methods={"GET"})
     */

    public function index(CommandeRepository $commandRepository): Response
    {
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandRepository->findAll(),
        ]);
    }


     /**
     * @Route("/back", name="back")
     */
    public function indexb(): Response
    {
        return $this->render('adminT.html.twig', [
            'controller_name' => 'CommandeController',
        ]);
    }

    /**
     * @Route("/new", name="commande_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $commande = new Commande();
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($commande);
            $entityManager->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/new.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_show", methods={"GET"})
     */
    public function show(Commande $commande): Response
    {
        return $this->render('commande/show.html.twig', [
            'commande' => $commande,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="commande_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('commande/edit.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="commande_delete", methods={"POST"})
     */
    public function delete(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $commande->getId(), $request->request->get('_token'))) {
            $entityManager->remove($commande);
            $entityManager->flush();
        }

        return $this->redirectToRoute('commande_index', [], Response::HTTP_SEE_OTHER);
    }



      /**
     * @Route("/pdf/list", name="commande_pdf", methods={"GET"})
     */
    public function pdf(CommandeRepository $commandeRepository): Response
    {

        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $commande = $commandeRepository->findAll();


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('commande/Listepdf.html.twig', [
            'commandes' => $commande,
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("Listepdf.pdf", [
            "Attachment" => true
        ]);
    }
      /**
     * @Route("/mailling/comm", name="Envoyer_Mail")
     */
    public function sendEmail(CommandeRepository $commandeRepository,\Swift_Mailer $mailer): Response
    {
      
        $message = (new \Swift_Message('VERFICATION'))
            ->setFrom('yasmine.triki@esprit.tn')
            ->setTo('yasmine.triki@esprit.tn')
            ->setBody("Valider Votre Compte")
        ;
        $mailer->send($message) ;

        return $this->render('commande/index.html.twig', [
            'commandes' => $commandeRepository->findAll(),
        ]);
    }
    /**
     * @Route("/search/commande", name="commande_r")
     */
    public function recherche(Request $request, CommandeRepository $commandeRepository)
    {
        $data=$request->get('data');
        $commande=$commandeRepository->reche($data);
        return $this->render('commande/index.html.twig', [
            'commandes' =>  $commande,  /*$allEmployeurQuery*/

            /* 'employers' => $employerRepository->findBy(array('nom' => $data)),*/
        ]);
    }
       /**
     * @Route("/triH/com", name="trih_commande")
     */
    public function Tri(Request $request,CommandeRepository $repository): Response
    {
        // Retrieve the entity manager of Doctrine
        $order=$request->get('type');
        if($order== "Croissant"){
            $commandes = $repository->tri_asc();
        }
        else {
            $commandes = $repository->tri_desc();
        }
        // Render the twig view
        return $this->render('commande/index.html.twig', [
            'commandes' => $commandes
        ]);
    }
    
}
