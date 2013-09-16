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

class ArchivoController extends Controller {

	public function nuevoAction() {

		$seccion = 'Archivos';
		$subseccion = 'Nuevo archivo';
		$titulo = 'Nuevo archivo';
		$mensajeinicial = 'Para comenzar por favor rellene el formulario';
		$mensajefinal = 'Su archivo fue guardado exitosamente...';
		$tipo = 1;
		//0 = ENTRADAS, 1 = ARCHIVOS, 2 = IMAGENES, 3 = CORREO
		$id = null;
		$accion = 'Nuevo';
		$url = $this -> generateUrl('proyecto_principal_archivo_nuevo');

		return DefaultController::procesar($id, $accion, $seccion, $subseccion, $titulo, $mensajeinicial, $mensajefinal, $tipo, $url, $this);
	}

	public function editarAction($id) {

		$seccion = 'Archivos';
		$subseccion = 'Editar archivo';
		$titulo = 'Editar archivo';
		$mensajeinicial = 'Para comenzar por favor rellene el formulario';
		$mensajefinal = 'Su archivo fue actualizado exitosamente...';
		$tipo = 1;
		$accion = 'Editar';
		$url = $this -> generateUrl('proyecto_principal_archivo_editar', array('id' => $id));

		return DefaultController::procesar($id, $accion, $seccion, $subseccion, $titulo, $mensajeinicial, $mensajefinal, $tipo, $url, $this);
	}

	public function listadoAction() {

		$firstArray = UtilitiesAPI::getDefaultContent('Archivos', 'Listado de archivos', 'Listado de archivos', 'Seleccione el archivo a editar', $this);
		$secondArray = array();

		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.tipo = :tipo
    								 ORDER BY d.fecha DESC') -> setParameter('tipo', '1');

		$secondArray['objects'] = $query -> getResult();
		$secondArray['url'] = $this -> generateUrl('proyecto_principal_archivo_editar');
		
		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Principal:listado.html.twig', $array);
	}
}
