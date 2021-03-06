<?php

namespace Proyecto\PrincipalBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Security\Core\SecurityContext;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use JMS\SecurityExtraBundle\Annotation\Secure;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Proyecto\PrincipalBundle\Entity\User;
use Proyecto\PrincipalBundle\Entity\Autores;
use Proyecto\PrincipalBundle\Entity\Data;
use Proyecto\PrincipalBundle\Entity\Categoria;
use Doctrine\ORM\EntityRepository;

class EntradaController extends Controller {

	public function nuevoAction() {

		$seccion = 'Entradas';
		$subseccion = 'Nueva entrada';
		$titulo = 'Nueva entrada';
		$mensajeinicial = 'Para comenzar por favor rellene el formulario';
		$mensajefinal = 'Su entrada fue guardada exitosamente...';
		$tipo = 0;
		//0 = ENTRADAS, 1 = ARCHIVOS, 2 = IMAGENES, 3 = CORREO
		$id = null;
		$accion = 'Nuevo';
		$url = $this -> generateUrl('proyecto_principal_entrada_nuevo');

		return DefaultController::procesar($id, $accion, $seccion, $subseccion, $titulo, $mensajeinicial, $mensajefinal, $tipo, $url, $this);
	}

	public function editarAction($id) {

		$seccion = 'Entradas';
		$subseccion = 'Editar entrada';
		$titulo = 'Editar entrada';
		$mensajeinicial = 'Para comenzar por favor rellene el formulario';
		$mensajefinal = 'Su entrada fue actualizada exitosamente...';
		$tipo = 0;
		$accion = 'Editar';
		$url = $this -> generateUrl('proyecto_principal_entrada_editar', array('id' => $id));

		return DefaultController::procesar($id, $accion, $seccion, $subseccion, $titulo, $mensajeinicial, $mensajefinal, $tipo, $url, $this);
	}

	public function listadoAction() {

		$firstArray = UtilitiesAPI::getDefaultContent('Entradas', 'Listado de entradas', 'Listado de entradas', 'Seleccione la entrada a editar', $this);
		$secondArray = array();

		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.tipo = :tipo
    								 ORDER BY d.fecha DESC') -> setParameter('tipo', '0');

		$secondArray['objects'] = $query -> getResult();
		$secondArray['url'] = $this -> generateUrl('proyecto_principal_entrada_editar');
		
		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Principal:listado.html.twig', $array);
	}
}
