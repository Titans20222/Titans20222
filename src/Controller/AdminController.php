<?php

namespace App\Controller;

use App\Entity\Users;
use App\Form\EditUserType;
use App\Repository\ProduitRepository;
use App\Repository\UsersRepository;

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
     * @Route("utilisateur/{id}", name="utilisateur_show", methods={"GET"})
     */
    public function show(Users $users): Response
    {
        return $this->render('admin/users/ShowUtilistateur.html.twig', [
            'user' => $users,
        ]);
    }
}
