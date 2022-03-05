<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

use App\Entity\Produit;
use App\Entity\Category;
use  App\Controller\CategoryController;
use App\Repository\ProduitRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\CategoryRepository;


class BoutiqueController extends AbstractController
{
    /**
     * @Route("/boutique", name="alpha")
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
}
