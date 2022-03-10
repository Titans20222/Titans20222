<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Proxies\__CG__\App\Entity\Evenement;
use CMEN\GoogleChartsBundle\GoogleCharts\Charts\PieChart;


class PiechartController extends AbstractController
{
    /**
     * @Route("/piechart", name="piechart")
     */
    public function index(): Response
    {
        return $this->render('piechart/index.html.twig', [
            'controller_name' => 'PiechartController',
        ]);
    }

/**
     * @Route("/{id}/test", name="test")
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function statAction( int $id)
    {
        
 
 
 
        $data = $this->getDoctrine()->getRepository(Evenement::class)->find($id);
 
        $pieChart = new PieChart();
  $x=0;
   $tab=$data->getReservation();
     foreach($tab as $d){
         $x+=$d->getNbrplace();
         echo($x);
     }
        
$pieChart->getData()->setArrayToDataTable( [
    ['Task', 'Hours per Day'],
    ['nombre des places disponible', $data->getNbrplacedispo()],
    ['nombre des places reserver', $x

],
]);
        $pieChart->getOptions()->setTitle('diponibilité des places');
        $pieChart->getOptions()->setHeight(400);
        $pieChart->getOptions()->setWidth(400);
        $pieChart->getOptions()->getTitleTextStyle()->setColor('#07600');
        $pieChart->getOptions()->getTitleTextStyle()->setFontSize(25);
 
         
        return $this->render('piechart/index.html.twig', array(
                'piechart' => $pieChart,
            )
 
        );
    }
}
