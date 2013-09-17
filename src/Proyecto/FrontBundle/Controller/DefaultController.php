<?php

namespace Proyecto\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Proyecto\PrincipalBundle\Entity\Data;
use Proyecto\PrincipalBundle\Entity\Categoria;

class DefaultController extends Controller
{
    public function indexAction()
    {
		$name = '';
		
	
		

        return $this->render('ProyectoFrontBundle:Default:index.html.twig', array('name' => $name));
    }
}
