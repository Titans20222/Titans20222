<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\Reservation1Type;
use App\Repository\ReservationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use Swift_Mailer;
use Symfony\Component\Notifier\Message\SmsMessage;
use Symfony\Component\Notifier\TexterInterface;
//use Symfony\Component\Notifier\Message\SmsMessage;
//use Symfony\Component\Notifier\NotifierInterface;
#use Twilio\Rest\Client;
use classes\SmsSender\SmsSender;
#require_once __DIR__ . '\vendor\autoload.php';
#use \vendor\twilio\sdk\src\Twilio\Rest\Client;
use Twilio\Rest\Client;
use Dompdf\Options;
use Dompdf\Dompdf;
use App\Entity\Evenement;
use App\Repository\EvennementRepository;

/**
 * @Route("/reservationadmin")
 */
class ReservationControlleradmin extends AbstractController
{
    /**
     * @Route("/", name="reservation_indexadmin", methods={"GET"})
     */
    public function index(Request $request,PaginatorInterface $paginator): Response
    {
        $donnees = $this->getDoctrine()->getRepository(Reservation::class)->findBy([],['id' => 'desc']);
        $articles = $paginator->paginate(
            $donnees,
            $request->query->getInt('page',1),1);

        return $this->render('reservationadmin/index.html.twig', [
            'reservations' =>$articles ,
        ]);
    }

    /**
     * @Route("/new", name="reservation_newadmin", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager, Swift_Mailer $mailer): Response
    {
        $reservation = new Reservation();
        $form = $this->createForm(Reservation1Type::class, $reservation);
  
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager->persist($reservation);


 


            $email = $reservation->getAdresseemail();
          $nbp = $reservation->getNbrplace();
          
         # $ev= $entityManager->findBy($id);
        #  $reservation->setIdevenement($ev);
          $reservation->getIdevenement()->setNbrplacedispo( $reservation->getIdevenement()->getNbrplacedispo() - $nbp);
         # $reservation->setIdevenement($req)
          $this->mailsender($mailer ,$email, $reservation);
            $entityManager->flush();

          #  $twilioNumber='+13606851303';
          #  $twilioClient = new Client('AC4e747cdc9de3b0741739beebb334962c','2f4079cf1db9100cdf150fb951d02c5e');
           # $sender       = new SmsSender($twilioClient);
            
           # $to      = '+21651966671';
           # $payload = [
            #    'from' => $twilioNumber,
             #   'body' => 'Thank you for registering, this is your unique code: ' . uniqid('hsjs', true),
            #];
            
           # $sender($to, $payload);
            
            #echo 'SMS sent successfully.';
            



            $pdfOptions = new Options();
            $pdfOptions->set('defaultFont', 'Arial');
            
            // Instantiate Dompdf with our options
            $dompdf = new Dompdf($pdfOptions);
            
            // Retrieve the HTML generated in our twig file
            $html = $this->render('pdf/mypdf.html.twig', [
                'mailadresse' => $reservation->getAdresseemail(),
                 'nbrplaces'=>$reservation->getNbrplace(),
                 'nomEvenement'=>$reservation->getIdevenement()->getNomEvenement(),
                 'lieuEvenement'=>$reservation->getIdevenement()->getNomLieu(),
                 'dateEvenement'=>$reservation->getIdevenement()->getDate(),
                 'prixEvenement'=>$reservation->getIdevenement()->getPrix()
            
            ]);
            
            // Load HTML to Dompdf
            $dompdf->loadHtml($html);
            
            // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
            $dompdf->setPaper('A4', 'portrait');
            
            // Render the HTML as PDF
            $dompdf->render();
            
            // Output the generated PDF to Browser (force download)
            $dompdf->stream("facture.pdf", [
                "Attachment" => false
            ]);
         



          #  return $this->redirect('pdf/mypdf.html.twig');
        
        
        }





     
        return $this->render('reservationadmin/new.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_showadmin", methods={"GET"})
     */
    public function show(Reservation $reservation): Response
    {
        return $this->render('reservationadmin/show.html.twig', [
            'reservation' => $reservation,
        ]);


      
    }

    /**
     * @Route("/{id}/edit", name="reservation_editadmin", methods={"GET", "POST"})
     */
    public function edit(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(Reservation1Type::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('reservationadmin/edit.html.twig', [
            'reservation' => $reservation,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="reservation_deleteadmin", methods={"POST"})
     */
    public function delete(Request $request, Reservation $reservation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$reservation->getId(), $request->request->get('_token'))) {
       
       $reservation->getIdevenement()->setNbrplacedispo( $reservation->getIdevenement()->getNbrplacedispo()+ $reservation->getNbrplace());
            $entityManager->remove($reservation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('reservation_index', [], Response::HTTP_SEE_OTHER);
    }
    public function mailsender(Swift_Mailer $mailer, string $mail, Reservation $reservation)
{

   
    $message = (new \Swift_Message('reservation Email'))
        ->setFrom('mostfa.wrad@gmail.com')
        ->setTo($mail)
        ->setBody(
            $this->renderView(
                // templates/emails/registration.html.twig
                'emails/reservation.html.twig',
                ['reservation' => $reservation]
            ),
            'text/html'

         
        );
        $mailer->send($message);
        // you can remove the following code if you don't define a text version for your emails
      //  ->addPart(
          //  $this->renderView(
                // templates/emails/registration.txt.twig
           //     'emails/registration.txt.twig',
            //    ['name' => $name]
            //),
            //'text/plain'
     //   )
    ;

    return $mailer->send($message);

   

}
function sendpdf( ){



}



}
