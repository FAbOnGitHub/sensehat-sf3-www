<?php

namespace FAb\SensorsBundle\Controller\API;

use FAb\SensorsBundle\Entity\Dataline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// N'oublons pas d'inclure Get


class DatalineController extends Controller
{

    public function getDatalinesAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();

        return $datalines;
    }

    public function getDatalineAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->find($id);

        return $datalines;
    }

}
