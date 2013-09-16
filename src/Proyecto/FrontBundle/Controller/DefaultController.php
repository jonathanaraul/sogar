<?php

namespace Proyecto\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	echo 'Hola estas en el front ;-) ';
		exit;
        return $this->render('ProyectoFrontBundle:Default:index.html.twig', array('name' => $name));
    }
}
