<?php

namespace App\Controller;

use App\Entity\Produit;
use App\Entity\Category;
use App\Form\ProduitType;
use App\Repository\ProduitRepository;
use App\Services\QrCodeService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints as Assert;
use Gedmo\Sluggable\Util\Urlizer;
use App\Service\UploaderHelper;
use Doctrine\Persistence\ManagerRegistry;



/**
 * @Route("/produit")
 */
class ProduitController extends AbstractController
{


    /**
     * @Route("/new", name="produit_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $produit = new Produit();
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           $imageFile=$form['imageFile']->getData();
           $destination = $this->getParameter('kernel.project_dir').'/public/uploads/peintures';
           $originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
           $newFilename = "file".'-'.uniqid().'.'.$imageFile->guessExtension();
           $imageFile->move(
               $destination,
               $newFilename
           );
           $produit->setFile($newFilename);
            $entityManager->persist($produit);
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }


        return $this->render('produit/new.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }



    /**
     * @Route("/show", name="produit_index", methods={"GET"})
     */
    public function index(ProduitRepository $produitRepository): Response
    {
        return $this->render('produit/index.html.twig', [
            'produits' => $produitRepository->findAll(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_show", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show.html.twig', [
            'produit' => $produit,
        ]);
    }
    /**
     * @Route("/qr/{id}", name="produit_show_qr", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function show_with_qr(Produit $produit, QrCodeService $qrcodeService): Response
    {

        $url = 'id: '.$produit->getId().' | ';
        $url = $url.'name: '.$produit->getName().' | ';
        $url = $url.'category: '.$produit->getDescription().' | ';
        $url = $url.'price: '.$produit->getPrice();

        $qrCode = $qrcodeService->qrcodeByProduit($url);
        $fileName = $qrCode[1];
        return $this->render('produit/show_with_qr.html.twig', [
            'produit' => $produit,
            'qrCode' => $qrCode[0],
            'fileName' => $fileName,
        ]);
    }


     /**
     * @Route("showCat/{id}", name="produit_showCat", methods={"GET"}, requirements={"id":"\d+"})
     */
    public function showByCat(ManagerRegistry $doctrine, $id ): Response
    {
        $categories = $doctrine->getRepository(Category::class)->findAll();
        $produits = $doctrine->getRepository(Produit::class)->findBy(['category'=> $id]);
        return $this->render('boutique/index.html.twig', [
            'produits' => $produits,
            'categories' => $categories
         ] );
    }



    /**
     * @Route("/{id}/edit", name="produit_edit", methods={"GET", "POST"}, requirements={"id":"\d+"})
     */
    public function edit(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ProduitType::class, $produit);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('produit/edit.html.twig', [
            'produit' => $produit,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="produit_delete", methods={"POST"}, requirements={"id":"\d+"})
     */
    public function delete(Request $request, Produit $produit, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$produit->getId(), $request->request->get('_token'))) {
            $entityManager->remove($produit);
            $entityManager->flush();
        }

        return $this->redirectToRoute('produit_index', [], Response::HTTP_SEE_OTHER);
    }
}
