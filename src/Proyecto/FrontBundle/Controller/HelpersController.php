<?php

namespace Proyecto\FrontBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Proyecto\PrincipalBundle\Entity\User;
use Proyecto\PrincipalBundle\Entity\Data;
use Proyecto\PrincipalBundle\Entity\Categoria;

class HelpersController extends Controller
{
    public function ultimosArticulosAction($tipo,$titulo)
    {
    	$array = array('titulo'=>$titulo );
	
		$em = $this->getDoctrine()->getManager();
		
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.tipo = :tipo
    								 ORDER BY d.fecha DESC') -> setParameter('tipo', $tipo);

		$array['objects'] = $query -> getResult();
		
	
        return $this->render('ProyectoFrontBundle:Helpers:ultimosarticulos.html.twig', $array);
    }
    public function galeriaAction($tipo,$titulo)
    {
    	$array = array('titulo'=>$titulo );
	
		$em = $this->getDoctrine()->getManager();
		
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.titulo = :tipo
    								 ORDER BY d.fecha ASC') -> setParameter('tipo', $tipo);

		$array['objects'] = $query -> getResult();
		
	
        return $this->render('ProyectoFrontBundle:Helpers:galeria.html.twig', $array);
    }

    public function slideshowAction()
    {
			
		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.titulo = :tipo
    								 ORDER BY d.fecha DESC') -> setParameter('tipo', 'slideshow');

		$secondArray['objects'] = $query -> getResult();
		
        return $this->render('ProyectoFrontBundle:Helpers:slideshow.html.twig', $secondArray);
    }

	 public function menuAction()
    {
			
		 $categorias = $this->getDoctrine()
        ->getRepository('ProyectoPrincipalBundle:Categoria')
        ->findByTipo(1);

		$array = array();
		
		for ($i=0; $i < count($categorias) ; $i++) { 
			$array[$i]['titulo'] = $categorias[$i]->getTitulo();
			$array[$i]['url'] = $this->generateUrl('proyecto_front_descargas_categoria', array('id' => $categorias[$i]->getId()));
		  
		}
		
        return $this->render('ProyectoFrontBundle:Helpers:menu.html.twig', array('elementos' => $array));
    }
}
