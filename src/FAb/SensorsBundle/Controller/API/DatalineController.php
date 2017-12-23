<?php

namespace FAb\SensorsBundle\Controller;

use FAb\SensorsBundle\Entity\Dataline;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

// N'oublons pas d'inclure Get


class DatalineController extends Controller
{

    public function getDatalineAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();

        return $datalines;
    }

    public function getDatalineAction()
    {
        $em = $this->getDoctrine()->getManager();

        $datalines = $em->getRepository('SensorsBundle:Dataline')->findAll();

        return $datalines;
    }

}
