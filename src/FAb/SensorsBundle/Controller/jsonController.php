<?php

namespace FAb\SensorsBundle\Controller;

use Monolog\Logger;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;


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


        $encoders = array(new XmlEncoder(), new JsonEncoder());
        $normalizers = array(new ObjectNormalizer());
        $serializer = new Serializer($normalizers, $encoders);

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

    /**
     * @Route("/listStation")
     */
    public function listStationAction()
    {

        $em = $this->getDoctrine()->getManager();

        $stations = $em->getRepository('SensorsBundle:Station')->findAll();
        if (!$stations) {
            $logger = new Logger();
            $logger->alert("No stations");
        }
        return new JsonResponse(array('data' => $stations));
    }

}
