<?php

namespace FAb\SensorsBundle\Controller\API;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use FOS\RestBundle\Controller\Annotations as Rest; // alias pour toutes les annotations
use FOS\RestBundle\Controller\Annotations\Get; // N'oublons pas d'inclure Get
use FOS\RestBundle\View\View;
//use FOS\RestBundle\View\ViewHandler;


class DatalineController extends Controller
{

    /**
     * @Rest\View()
     * @Rest\Get("/api/datalines/")
     */
    public function getDatalinesAction()
    {
        $em = $this->getDoctrine()->getManager();
        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();

        $view = View::create($datalines);
        $view->setHeader('Access-Control-Allow-Origin', '*');
        $view->setFormat('json');
        return $view;
    }

    /**
     * @Rest\View()
     * @Rest\Get("/api/datalines/{id}")
     */
    public function getDatalineAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $serializer = $this->get('serializer');
        $dataline = $em->getRepository('SensorsBundle:Dataline')->find($id);


        $data = $serializer->serialize($dataline, 'json');
        $response = new Response($data);
        $response->headers->set('Access-Control-Allow-Origin', '*');
        $response->headers->set('Content-Type', 'application/json');
        return $response;
    }


}
