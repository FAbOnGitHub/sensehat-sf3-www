<?php

namespace FAb\SensorsBundle\Controller\API;


use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations


class StationController extends Controller
{
    /**
     * @ Rest\View()
     * @Rest\Get("/api/stations")
     */
    public function getStationsAction()
    {
        $em = $this->getDoctrine()->getManager();

        $stations = $em->getRepository('SensorsBundle:Station')->findAll();
        $formatted = [];
        foreach ($stations as $station) {
            $formatted[] = $station->__toArray();
        }

        return new JsonResponse($formatted);
    }

    /**
     * @Rest\View()
     * @Rest\Get("/api/stations/{station_id}")
     */
    public function getStationAction($station_id)
    {
        $em = $this->getDoctrine()->getManager();

        $station = $em->getRepository('SensorsBundle:Station')->find($station_id);

        return new JsonResponse($station);
        return $station;
    }
    /**
     * @ Rest\View()
     * @Rest\Post("/api/stations/{station_id}")
     */
    public function postStationAction(Request $request)
    {
        return $request;
    }
}
