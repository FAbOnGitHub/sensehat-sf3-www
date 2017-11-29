<?php

namespace FAb\GeoBiduleBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('GeoBiduleBundle:Default:index.html.twig');
    }
}
