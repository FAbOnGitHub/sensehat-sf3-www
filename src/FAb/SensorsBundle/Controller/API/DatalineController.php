<?php

namespace FAb\SensorsBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\Controller\Annotations as Rest;

// N'oublions pas d'inclure Get


class DatalineController extends Controller
{

    /**
     * @Rest\Get("/datalines/{id}")
     */
    public function getDatalineAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('serializer');
        $dataline = $em->getRepository('SensorsBundle:Dataline')->find($id);


        $data = $serializer->serialize($dataline, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

    /**
     * @Rest\Get("/datalines/")
     */
    public function getDatalinesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('serializer');


        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();


        $data = $serializer->serialize($datalines, 'json');
        $response = new Response($data);
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }

}
