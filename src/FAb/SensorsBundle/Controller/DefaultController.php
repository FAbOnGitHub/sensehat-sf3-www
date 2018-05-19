<?php

namespace FAb\SensorsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request as Request;

class DefaultController extends Controller {

    /**
     * @Route("/")
     */
    public function indexAction() {
        return $this->render('SensorsBundle:Default:index.html.twig');
    }

    public function pushAction(Request $request) {
        $raw_data = $request->get('data');
        $json_data = json_decode($raw_data);
        if (!is_array($json_data)) {
            $response = new JsonResponse(500, 'Bad format');
            return $response;
        }
        foreach ($json_data as $node) {
            $dataset = new Dataset();
            $dataset->setDatetime($node['TS']);
            $dataset->setTemperature($node['T']);
            $dataset->setHumdity($node['H']);
            $dataset->setPressure($node['P']);
            $dataset->setMagnet($node['M']);
            $dataset->persist();
        }
        $temp = $request->get('temperature');
        $humidiy = $request->get('humidity');
        $pressure = $request->get('pressure');
        $magn = $request->get('magn');

        $response = new JsonResponse(
                array(
            'data' => 'Ok',
            'temp' => $temp,
            'humidity' => $humidiy,
            'pressure' => $pressure,
            'magn' => $magn)
        );
        return $response;
    }

    /**
     * @Route("/graph", name="visu")
     */
    public function grpahAction() {
        return $this->render('SensorsBundle:Default:graph.html.twig');
    }


}
