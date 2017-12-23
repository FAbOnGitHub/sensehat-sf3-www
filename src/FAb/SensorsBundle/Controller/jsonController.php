<?php

namespace FAb\SensorsBundle\Controller;

use Monolog\Logger;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;


class jsonController extends Controller
{

    public function getDatalinesAction()
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

    public function getStationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stations = $em->getRepository('SensorsBundle:Station')->findAll();
        if (!$stations) {
            $logger = new Logger();
            $logger->alert("No stations");
        }
        return new Response($stations);
    }

}
