<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
* @Route("/admin", name="admin")
*/
    public function admin(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/contact", name="contact")
     */
    public function contact(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/admin1", name="admin1")
     */
    public function admin1(): Response
    {
        return $this->render('adminT.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/successR", name="successR")
     */
    public function successR(): Response
    {
        return $this->render('registration/confirmationM.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/loginArtisan", name="loginArtisan")
     */
    public function adminTLogin(): Response
    {
        return $this->render('admin/login.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
    /**
     * @Route("/list" ,name="listPrduit")
     */
    public function listP(): Response
    {
        return $this->render('adminArtisan/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }
}
