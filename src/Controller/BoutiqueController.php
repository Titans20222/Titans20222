<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Produit;
use App\Services\QrCodeService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("boutique/")
 */
class BoutiqueController extends AbstractController
{
    /**
     * @Route("/show", name="alpha")
     */

    public function index(): Response
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)->findAll();
        $produits =  $this->getDoctrine()->getRepository(Produit::class)->findAll();
        return $this->render('boutique/index.html.twig', [
            'produits' => $produits,
            'categories' => $categories
        ] );



    }

    /**
     * @Route("/{id}", name="produit_show1", methods={"GET"})
     */
    public function show(Produit $produit): Response
    {
        return $this->render('produit/show1.html.twig', [
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

}
