<?php

namespace Proyecto\FrontBundle\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Proyecto\PrincipalBundle\Entity\Data;
use Proyecto\PrincipalBundle\Entity\Categoria;
use Proyecto\PrincipalBundle\Entity\Entrada;
use Proyecto\PrincipalBundle\Entity\Usuario;

class DefaultController extends Controller {
	public function inicioAction() {
		$array = UtilitiesAPI::getDefaultContent('inicio', $this);

		return $this -> render('ProyectoFrontBundle:Default:inicio.html.twig', $array);
	}

	public function organizacionAction() {
		$array['menu'] = 'organizacion';
		$array['titulo'] = 'La Organizaci&oacute;n';
		$array['objects'] = APIController::findDataByTitleCategory($array['menu'], $this);
		$array['ruta'] = 'proyecto_front_organizacion_articulo';

		return $this -> render('ProyectoFrontBundle:Default:articulos.html.twig', $array);
	}

	public function informacionAction() {
		$array['menu'] = 'informacion';
		$array['titulo'] = 'Informaci&oacute;n';
		$array['ruta'] = 'proyecto_front_informacion_articulo';
		$array['objects'] = APIController::findDataByTitleCategory($array['menu'], $this);

		return $this -> render('ProyectoFrontBundle:Default:articulos.html.twig', $array);
	}

	public function articuloAction($id) {
		$array['object'] = $this -> getDoctrine() -> getRepository('ProyectoPrincipalBundle:Data') -> find($id);

		if (!$array['object']) {
			throw $this -> createNotFoundException('Articulo no encontrado');
		}

		if ($array['object'] -> getCategoria() -> getTitulo() != 'informacion' && $array['object'] -> getCategoria() -> getTitulo() != 'organizacion') {
			throw $this -> createNotFoundException('Articulo no encontrado');
		}

		$array['menu'] = $array['object'] -> getCategoria() -> getTitulo();

		return $this -> render('ProyectoFrontBundle:Default:articulo.html.twig', $array);
	}

	public function descargasAction() {
		$array['menu'] = 'descargas';

		$array['objects'] = $this -> getDoctrine() -> getRepository('ProyectoPrincipalBundle:Categoria') -> findByTipo(1);

		$em = $this -> getDoctrine() -> getManager();
		$query = $em -> createQuery('SELECT d
    								 FROM ProyectoPrincipalBundle:Data d,
    	 								  ProyectoPrincipalBundle:Categoria c
   	 								 WHERE d.categoria = c.id AND
   	 								       c.tipo = :tipo
    								 ORDER BY d.titulo ASC') -> setParameter('tipo', '1');

		$array['downloads'] = $query -> getResult();

		return $this -> render('ProyectoFrontBundle:Default:descargas.html.twig', $array);
	}

	public function contactoAction() {
		$array = array();
		$array['menu'] = 'contacto';

		$data = new Entrada();
		$tipo = '3';
		//3= Entrada de archivos

		$form = $this -> createFormBuilder($data) -> add('nombre', 'text') -> add('email', 'text') -> add('mensaje', 'textarea') -> add('categoria', 'entity', array('class' => 'ProyectoPrincipalBundle:Categoria', 'query_builder' => function(EntityRepository $er) use ($tipo) {
			return $er -> createQueryBuilder('sc') -> where('sc.tipo = :tipo') -> setParameter('tipo', $tipo);
		}, )) -> add('file') -> getForm();

		if ($this -> getRequest() -> isMethod('POST')) {
			$form -> bind($this -> getRequest());

			if ($form -> isValid()) {

				//$array = array();
				$array['mensaje'] = 'Su mensaje fue enviado exitosamente...Su respuesta sera enviada a su correo electr&oacute;nico y a su vez podr&aacute; leerla a trav&eacute;s de su perfil en nuestro portal web cuando sea procesada...';
				$array['titulo'] = 'Mensaje Enviado';

				$em = $this -> getDoctrine() -> getManager();
				$data -> setLeido(0);
				$data -> setRespondido(0);
				$data -> setFecha(new \DateTime());
				$em -> persist($data);
				$em -> flush();
				return $this -> render('ProyectoFrontBundle:Helpers:mensaje.html.twig', $array);
			}
		}

		$array['form'] = $form -> createView();

		return $this -> render('ProyectoFrontBundle:Default:contacto.html.twig', $array);
	}

}
