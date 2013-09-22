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

class DefaultController extends Controller {

	public function indexAction() {
		$firstArray = UtilitiesAPI::getDefaultContent('Inicio', 'Panel de Control', 'Panel de Control', 'Bienvenido seleccione su categoría', $this);
		$secondArray = array();

		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Principal:index.html.twig', $array);
	}

	public static function procesar($id,$accion,$seccion,$subseccion,$titulo,$mensajeinicial,$mensajefinal,$tipo,$url,$class) {
		
		$firstArray = UtilitiesAPI::getDefaultContent($seccion, $subseccion, $titulo, $mensajeinicial, $class);
		$firstArray['accion'] = $accion;
		$firstArray['url'] = $url;
		
		if($accion == 'Nuevo')$data = new Data();
		else $data = $class -> getDoctrine() -> getRepository('ProyectoPrincipalBundle:Data') -> find($id);
		

		$form = $class -> createFormBuilder($data) -> add('titulo', 'text') -> add('mensaje', 'textarea') -> add('categoria', 'entity', array('class' => 'ProyectoPrincipalBundle:Categoria', 'query_builder' => function(EntityRepository $er) use ($tipo) {
			return $er -> createQueryBuilder('sc') -> where('sc.tipo = :tipo') -> setParameter('tipo', $tipo);
		}, )) -> add('file') -> add('fecha') -> add('habilitado') -> getForm();

		if ($class -> getRequest() -> isMethod('POST')) {
			$form -> bind($class -> getRequest());

			if ($form -> isValid()) {

				$firstArray = UtilitiesAPI::getDefaultContent($seccion,$subseccion,'Guardado', $mensajefinal, $class);
				$secondArray = array('object' => null);
				$array = array_merge($firstArray, $secondArray);

				$em = $class -> getDoctrine() -> getManager();
				$data -> setUsuario(UtilitiesAPI::getActiveUser($class));
				if($accion == 'Nuevo')$data -> setFecha(new \DateTime());
				$em -> persist($data);
				$em -> flush();
				return $class -> render('ProyectoPrincipalBundle:Helpers:mensaje.html.twig', $array);
			}
		}

		$secondArray = array('form' => $form -> createView(), 'object' => null);

		$array = array_merge($firstArray, $secondArray);
		return $class -> render('ProyectoPrincipalBundle:Principal:ingreso.html.twig', $array);
	}

	public function eliminarAction() {
		$peticion = $this -> getRequest();
		$doctrine = $this -> getDoctrine();
		$post = $peticion -> request;

		$id = $post -> get("id");
		UtilitiesAPI::removeData($id, $this);

		$respuesta = new response(json_encode(array('estado' => true)));
		$respuesta -> headers -> set('content_type', 'aplication/json');
		return $respuesta;
	}

	public function modificarAction() {
		$peticion = $this -> getRequest();
		$doctrine = $this -> getDoctrine();
		$post = $peticion -> request;

		$id = $post -> get("id");
		$valor = intval($post -> get("valor"));
		$data = $this -> getDoctrine() -> getRepository('ProyectoPrincipalBundle:Data') -> find($id);
		$em = $this -> getDoctrine() -> getManager();
		$data = $em -> getRepository('ProyectoPrincipalBundle:Data') -> find($id);
		$data -> setHabilitado($valor);
		$em -> flush();

		$respuesta = new response(json_encode(array('estado' => true)));
		$respuesta -> headers -> set('content_type', 'aplication/json');
		return $respuesta;
	}

	public function acercaAction() {
		$parameters = UtilitiesAPI::getParameters($this);
		$user = UtilitiesAPI::getActiveUser($this);
		$autors = UtilitiesAPI::getAutors($this);
		$auxiliar = array('descripcionusuario' => stripcslashes(html_entity_decode($user -> getDescripcion())));

		$firstArray = UtilitiesAPI::getDefaultContent('Acerca', $parameters -> getNombre() . ' ' . $parameters -> getVersion(), $this);
		$secondArray = array('autors' => $autors, 'auxiliar' => $auxiliar);

		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Principal:acerca.html.twig', $array);
	}

}
