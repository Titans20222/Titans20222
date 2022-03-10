<?php

namespace App\Controller;

use ApiPlatform\Core\JsonApi\Serializer\ObjectNormalizer;
use App\Data\SearchData;
use App\Entity\Commentaire;
use App\Entity\Users;
use App\Form\SearchForm;

use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Serializer;


class UsersController extends AbstractController
{
    /**
     * @Route("/Allusers", name="users")
     */
    public function Allusers(NormalizerInterface $normalizer)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->findAll();
        $jsonContent = $normalizer->normalize($users, 'json', ['users' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }

    /**
     * @Route("/AddUser/new", name="AddUser")
     */
    public function AddUser(Request $request,NormalizerInterface $normalizer)
    {
        $em = $this->getDoctrine()->getManager();
        $users = new Users();
        $users->setNom($request->get('nom'));
        $users->setPrenom($request->get('prenom'));
        $users->setEmail($request->get('email'));
        $users->setPassword($request->get('password'));
        $users->setAdresse($request->get('adresse'));
        $users->setRoles($request->get('roles'));
        $em->persist($users);

        $jsonContent = $normalizer->normalize($users, 'json', ['groups' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }


    /**
     * @Route("/userById/{id}", name="usersby")
     */
    public function AllsersById( NormalizerInterface $normalizer, $id)
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);
        $users = $repository->find($id);
        $jsonContent = $normalizer->normalize($users, 'json', ['users' => 'post:read']);
        return new Response(json_encode($jsonContent));
    }





    /**
     * @Route("/addUserj/new", name="addUserj/new")
     * @Method("GET")
     */
    public function addUserj(Request $request, NormalizerInterface $Normalizer )
    {

        $em=$this->getDoctrine()->getManager();
        $users=new Users();
        $users->setNom($request->get('nom'));

        $users->setPrenom($request->get('prenom'));
        $users->setPassword($request->get("password"));
        $users->setEmail($request->get("email"));
        $users->setRoles($request->get("roles"));
        $users->setAdresse($request->get("adresse"));
        $em->persist($users);
        $em->flush();
        $jsonContent=$Normalizer->normalize($users,'json',['groups'=>'post:read']);

        return new Response(json_encode($jsonContent));




    }

    /**
     * @Route("/addUser", name="add_reparation")
     * @Method("GET")
     */

    public function ajouterUser(Request $request)
    {
        $users = new Users();



        $em = $this->getDoctrine()->getManager();

        $users->setPrenom($request->get('prenom'));
        $users->setPassword($request->get("password"));
        $users->setEmail($request->get("email"));
        $users->setRoles($request->get("roles"));
        $users->setAdresse($request->get("adresse"));

        $em->persist($users);
        $em->flush();
        $serializer = new Serializer([new ObjectNormalizer()]);
        $formatted = $serializer->normalize($users);
        return new JsonResponse($formatted);

    }

    
    /**
     * @Route("/pass", name="pass")
     */
    public function adminTLogin(): Response
    {
        return $this->render('security/reset_password.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }



}
