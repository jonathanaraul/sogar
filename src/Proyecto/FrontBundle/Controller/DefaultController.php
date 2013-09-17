<?php

namespace Proyecto\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Proyecto\PrincipalBundle\Entity\Data;
use Proyecto\PrincipalBundle\Entity\Categoria;

class DefaultController extends Controller
{
    public function inicioAction()
    {
		$array['menu'] = 'inicio';
		
        return $this->render('ProyectoFrontBundle:Default:inicio.html.twig', $array );
    }
    public function organizacionAction()
    {
		$array['menu'] = 'organizacion';
		
        return $this->render('ProyectoFrontBundle:Default:organizacion.html.twig', $array );
    }
    public function descargasAction()
    {
		$array['menu'] = 'descargas';
		
		$array['objects'] = $this->getDoctrine()
        ->getRepository('ProyectoPrincipalBundle:Categoria')
        ->findByTipo(1);
		
		
		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.tipo = :tipo
    								 ORDER BY d.fecha DESC') -> setParameter('tipo', '1');

		$array['downloads'] = $query -> getResult();

        return $this->render('ProyectoFrontBundle:Default:descargas.html.twig', $array );
    }
    public function contactoAction()
    {
		$array['menu'] = 'contacto';
		
        return $this->render('ProyectoFrontBundle:Default:contacto.html.twig', $array );
    }
    public function informacionAction()
    {
		$array['menu'] = 'informacion';
		
        return $this->render('ProyectoFrontBundle:Default:informacion.html.twig', $array );
    }
}
