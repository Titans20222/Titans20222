<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Users;


class ProfileController extends AbstractController
{
    /*
     * @Route("/profile", name="profile")
     */
    public function index(): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');


        $users = $this->getUsers();

        return new Response('Well hi there '.$users->getNom());
    }
}
