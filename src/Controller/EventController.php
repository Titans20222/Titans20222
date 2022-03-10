<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Evenement;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\EvenementType;
use Twilio\Rest\Client;
use classes\SmsSender\SmsSender;
 /**
     * @Route("/event")
     */
   
class EventController extends AbstractController
{
   

 /**
     * @Route("/show", name="evenement_indexadmin" , methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Evenement::class)->findBy([],['id' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),2);
        return $this->render('evenementadmin/index.html.twig', [
            'evenements' =>$articles ,
        ]);
    }
 /**
     * @Route("/new", name="evenement_newadmin", methods={"GET", "POST"})
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

            return $this->redirectToRoute('evenement_indexadmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenementadmin/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="evenement_showadmin", methods={"GET"})
     */
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenementadmin/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

 /**
     * @Route("/{id}/edit", name="evenement_editadmin", methods={"GET", "POST"})
     */
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('evenement_indexadmin', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenementadmin/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form->createView(),
        ]);
    }

     /**
     * @Route("/{id}", name="evenement_deleteadmin", methods={"POST"})
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
                   'body' => 'salut je vous informe que l evenement du est annuler' ,
               ];
               $numtel="";
               $sender($to, $payload);
               
               echo 'SMS sent successfully.';
               
   
   
          
            } 
           $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('evenement_indexadmin', [], Response::HTTP_SEE_OTHER);
    }
}
