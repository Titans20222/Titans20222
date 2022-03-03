<?php

namespace App\Controller;

use App\Entity\LigneDeCommande;
use App\Entity\Commande;
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

    /*public function montantAction()
    {
        $em=$this->getDoctrine()->getManager();

        //$fs=$em->getRepository(clubs::class)->findQB();
        $fs=$em->getRepository(commande::class)->montant();

        $em->flush();
        $serializer = new Serializer( [new ObjectNormalizer()]);
        $formated = $serializer->normalize($fs);
        return new JsonResponse($formated);
    }*/

       /* $session = $request->getSession();
        if (!$session->has('name'))
        {
            $this->get('session')->getFlashBag()->add('info', 'Erreur de  Connection veuillez se connecter .... ....');
            return $this->redirectToRoute('app_register');
        }
        else
        {

            $name = $session->get('name');
            return $this->render('commande/index.html.twig', ['name'=>$name,
                'commandes' => $commandeRepository->findAll(),
            ]);
        }
*/

   /* /**
     * @Route("/new", name="commande_new", methods={"GET","POST"})
     * @param Request $request
     * @param ProduitRepository $produitRepository
     * @param $Numcommande
     * @param $Numc
     * @param $prix_total
     * @return Response
     */
   /* public function new(Request $request, ProduitRepository $produitRepository, $Numcommande, $Numc, $prix_total): Response
    {
        $session = $request->getSession();
        if (!$session->has('name'))
        {
            $this->get('session')->getFlashBag()->add('info', 'Erreur de  Connection veuillez se connecter .... ....');
            return $this->redirectToRoute('app_register');
        }
        else
        {
            $name = $session->get('name');
            $commande = new Commande();
            $form = $this->createForm(CommandeType::class, $commande);
            $form->handleRequest($request);
            $lignedecommande = new LigneDeCommande();
            $f = $this->createForm(LigneDeCommandeType::class, $lignedecommande);
            $f->handleRequest($request);
            $totht = 0;
            $totva = 0;
            $totttc = 0;
            $montht = 0;
            $lig = 0;

            if (!$session->has('commande'))
            {
                $session->set('commande',array());

            }
            $session = $request->getSession();
            $name = $session->get('name');
            $choix = "";
            $Tabcomm = $session->get('commande', []);

            if ($form->isSubmitted() || $f->isSubmitted()) {

                $choix = $request->get('bt');
                if($choix =="Valider"){
                    $em = $this->getDoctrine()->getManager();
                    $lig = sizeof($Tabcomm);
                    for ($i = 1;$i<=$lig;$i++)
                    {
                        $lignedecommande = new LigneDeCommande();
                        $prod = $produitRepository->findOneBy(array('id'=>$Tabcomm[$i]->getProduit()));
                        $lignedecommande->setProduit($prod);
                        $lignedecommande->setLigne($i);
                      //  $lignedecommande->setNumcommande($Numcommande);
                        $lignedecommande->setPrix($Tabcomm[$i]->getPv());
                        $lignedecommande->setQte($Tabcomm[$i]->getQte());
                        $em->persist($lignedecommande);
                        $em->flush();
                        $montht = $Tabcomm[$i]->getPv()*$Tabcomm[$i]->getQte();
                        $monttva = $montht *($Tabcomm[$i]->getTva())*0.01;
                        $totht = $totht + $montht;
                        $totva = $totva + $monttva;
                        $totttc = $totttc + ($totht + $totva);
                    }

                    $commande->setNumc($Numc);

                    $commande->setPrix_total($prix_total);
                    $em->persist($commande);

                    $em->flush();
                    $session->clear();
                }
                else if($choix =="Add"){
                    $montht = $lignedecommande->getPrix()*$lignedecommande->getQte();
                    $ligne = sizeof($Tabcomm)+1;
                    $lignedecommande->setNumcommande($Numcommande);
                    $lignedecommande->setLigne($ligne);
                    $Tabcomm[$lig] = $lignedecommande;
                    $session->set('commande',$Tabcomm);
                }
            }
            return $this->render('commande/new.html.twig', [
                'commande' => $commande,'lcomm'=>$Tabcomm,
                'form' => $form->createView(),
                'lcommande' => $lignedecommande,'name'=>$name,
                'f' => $f->createView(),'numc'=>$Numc,
                'prix_total'=>$prix_total,'montht'=>$montht,'ligne'=>$ligne,

            ]);
        }
    }*/
}
