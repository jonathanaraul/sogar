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
		$array['titulo'] = 'La Organizaci&oacute;n';
		$array['objects'] = APIController::findDataByTitleCategory($array['menu'],$this);
		$array['ruta'] = 'proyecto_front_organizacion_articulo';
		
        return $this->render('ProyectoFrontBundle:Default:articulos.html.twig', $array );
    }

    public function informacionAction()
    {
		$array['menu'] = 'informacion';
		$array['titulo'] = 'Informaci&oacute;n';
		$array['ruta'] = 'proyecto_front_informacion_articulo';
		$array['objects'] = APIController::findDataByTitleCategory($array['menu'],$this);
									 		
        return $this->render('ProyectoFrontBundle:Default:articulos.html.twig', $array );
    }
    public function articuloAction($id)
    {
		$array['object'] = $this->getDoctrine()
        ->getRepository('ProyectoPrincipalBundle:Data')
        ->find($id);
		
		  if (!$array['object']) {
        	throw $this->createNotFoundException('Articulo no encontrado');
    	}
		  
		  if ($array['object']->getCategoria()->getTitulo() != 'informacion' && $array['object']->getCategoria()->getTitulo() != 'organizacion') {
        	throw $this->createNotFoundException('Articulo no encontrado');
    	}
		
		$array['menu'] = $array['object']->getCategoria()->getTitulo();
									 		
        return $this->render('ProyectoFrontBundle:Default:articulo.html.twig', $array );
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
    								 ORDER BY d.titulo ASC') -> setParameter('tipo', '1');

		$array['downloads'] = $query -> getResult();

        return $this->render('ProyectoFrontBundle:Default:descargas.html.twig', $array );
    }
    public function contactoAction()
    {
		$array['menu'] = 'contacto';
		
        return $this->render('ProyectoFrontBundle:Default:contacto.html.twig', $array );
    }

}
