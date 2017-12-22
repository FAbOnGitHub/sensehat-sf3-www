<?php

namespace FAb\SensorsBundle\Controller;

use Monolog\Logger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;

use FOS\RestBundle\Controller\Annotations\Get;
use FOS\RestBundle\Controller\Annotations\View;
use Symfony\Component\HttpFoundation\Response;


class jsonController extends Controller
{
    /**
     * @Route("/listDataline")
     */
    public function listDatalineAction()
    {

        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();
        if (!$datalines) {
            $logger = new Logger();
            $logger->alert("No dataline");
            return new JsonResponse(array('data' => 'error'));
        }

        $data = array();
        foreach ($datalines as $dataline) {
            $data[] = array(
                'datetime' => $dataline->getDatetime(),
                'temperature' => $dataline->getTemperature(),
                'humidity' => $dataline->getHumidity(),
                'pressure' => $dataline->getPressure(),
                'magnetism' => $dataline->getMagnetism(),
                'temperature_cpu' => $dataline->getTemperatureCpu(),
            );

        }
        return new JsonResponse(array($data));
    }

    //* @Route("/listStation")
    /**
     * @Get("/stations")
     * @Get(
     *     path = "/listStation/{id}",
     *     name = "list_station",
     * )
     * @View
     */
    public function listStationAction()
    {

        $em = $this->getDoctrine()->getManager();

        $stations = $em->getRepository('SensorsBundle:Station')->findAll();
        if (!$stations) {
            $logger = new Logger();
            $logger->alert("No stations");
        }
        return new Response( $stations );
    }

}
