<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Mymap;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Mime\Address;
use SebastianBergmann\Environment\Console;
use Symfony\Polyfill\Intl\Idn\Info;
use Twilio\Rest\Client;
use classes\SmsSender\SmsSender;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;
use App\Data\SearchDataRec1;
use App\Form\SearchFormRec1;


/**
 * @Route("/evenement")
 */
class EvenementController extends AbstractController
{

    /**
     * @Route("/all", name="all", methods={"GET"})
     */
    public function index1(NormalizerInterface $Normalizer): Response
    {
        // return $this->render('evenement/index.html.twig', [
        //     'evenements' => $evenementRepository->findAll(),
       // ]);
      // $evenements=$evenementRepository->findAll();
   $repository= $this->getDoctrine()->getRepository(Evenement::class);
   $evenements=$repository->findAll();
   //($evenements);
      $jsonContent=$Normalizer->normalize($evenements,'json',['groups'=>'evenement']);
      dump($jsonContent);
      return new Response(json_encode($jsonContent));
     //  $this->render('evenement/index1.html.twig',[
       //    'data'=>$jsonContent,
        //]);

    }
    /**
     * @Route("/show", name="evenement_index", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Evenement::class)->findBy([],['date' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),2);
            

        return $this->render('evenement/index.html.twig', [
            'evenements' =>$articles ,
        ]);
    }






  /**
     *
     * @Route("/", name="evenement_index")
     */
    public function reclamationcherche(EvenementRepository $evenementRepository, Request $request,PaginatorInterface $paginator):Response
    {
        $data = new SearchDataRec1();
        

        $form = $this->createForm(SearchFormRec1::class,$data, [
         
        ]);
        $form->handleRequest($request);
        $evenement=$evenementRepository->findSearch($data);
        $evenement= $paginator->paginate(
            $evenement=$evenementRepository->findAll(), // Requête contenant les données à paginer (ici nos articles)kkkk
                 $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
                  // Nombre de résultats par page
            );
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenement,
            'form' => $form->createView(),
        ]);



    }












     

    /**
     * @Route("/new", name="evenement_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        
        $form = $this->createForm(EvenementType::class, $evenement);
        
          $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
          # $evenement = $form->getData();
         #   $image = $evenement->getImage();
           # $image = $evenement->getFile();
            #dd($image);
          #  $imageNom = md5(uniqid()).'.'.$image->guessExtension();

          
// Google Maps Geocoder
         
         $p = $evenement->getNomLieu();


      #   $map = array('address' => '', 'lat' => '', 'lng' => '', 'city' => '', 'department' => '', 'region' => '', 'country' => '', 'postal_code' => '');

  #  $map = Mymap::geocodeAddress($p);
#$res = $map->geocodeAddress($p);




#$evenement->setLat( $map['lat']);

#$x = $res[1];
#$evenement->setLong( $map['lng']);
            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_show", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="evenement_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_delete", methods={"POST"})
     */
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->request->get('_token'))) {
           
           $data = $evenement->getReservation();
           foreach( $data as $d){
               
               $numtel = $d->getNumtel();
               $twilioNumber='+13606851303';
               $twilioClient = new Client('AC4e747cdc9de3b0741739beebb334962c','2f4079cf1db9100cdf150fb951d02c5e');
               $sender= new SmsSender($twilioClient);
               
               $to = '+216'.$numtel;
               #28003486
               $payload = [
                   'from' => $twilioNumber,
                   'body' => 'salut je vous informe que l evenement du est annuler'.+$d->getIdevenement->__toString(),
               ];
               $numtel="";
               $sender($to, $payload);
               
               echo 'SMS sent successfully.';
               
   
   
          
            } 
           $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_index', [], Response::HTTP_SEE_OTHER);
    }


 }
