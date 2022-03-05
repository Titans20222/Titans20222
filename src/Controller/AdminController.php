<?php

namespace App\Controller;

use App\Entity\Commande;
use App\Entity\Users;
use App\Form\CommandeType;
use App\Form\EditUserType;
use App\Repository\CommandeRepository;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{


    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    /**
     * @Route("admin/utilisateurs", name="admin_utilisateurs")
     */
    public function usersList(UsersRepository $users)
    {
        return $this->render('admin/users/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    /**
     * @Route("admin/utilisateurs/modifier/{id}", name="admin_modifier_utilisateur")
     */
    public function editUser(Users $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Utilisateur modifié avec succès');
            return $this->redirectToRoute('admin_utilisateurs');
        }

        return $this->render('admin/users/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }
    /**
     * @Route("admin/utilisateur/{id}", name="admin_supprimer_utilisateur")
     */
    public function deleteById($id,UsersRepository $userRepository): Response
    {
        $user=$userRepository->find($id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute('admin_utilisateurs', [], Response::HTTP_SEE_OTHER);
    }


    /**
     * @Route("admin/commande", name="admincommande_index", methods={"GET"})
     */
    public function commandeList(UsersRepository $commandes)
    {
        return $this->render('admin/commandes/showcommandes.html.twig', [
            'commandes' => $commandes->findAll(),
        ]);
    }


    /**
     * @Route("admin/{id}/edit", name="admincommande_edit", methods={"GET", "POST"})
     */
    public function editcommande(Request $request, Commande $commande, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CommandeType::class, $commande);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admincommande_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('admin/commandes/editcommande.html.twig', [
            'commande' => $commande,
            'form' => $form->createView(),
        ]);
    }

}
