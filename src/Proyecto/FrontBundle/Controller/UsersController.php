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

class UsersController extends Controller {

	public function validacionAction() {
		$usuario = UtilitiesAPI::getActiveUser($this);

		if ($usuario == NULL || $usuario -> getJerarquia() == true) 
			return $this -> redirect($this -> generateUrl('proyecto_front_homepage'));
			//return $this->redirect($this->generateUrl('proyecto_principal_homepage'));
		 else 
			return $this -> redirect($this -> generateUrl('proyecto_front_homepage'));

		return $this -> render('ProyectoFrontBundle:Default:inicio.html.twig', $array);
	}
	public function perfilAction() {

		$menu = 'perfil';
		$array = UtilitiesAPI::getDefaultContent($menu,$this);
		$array['mensaje'] = 'Usuario actualizado exitosamente...Sus modificaciones han sido guardadas...';
		$array['titulo'] = 'Usuario Actualizado';
		$array['url'] = $this -> generateUrl('proyecto_front_perfil');
		$array['cabecera1'] = 'Mi';
		$array['cabecera2'] = 'Perfil';
		
		return UsersController::procesar($array,$this);		
	}
	public function registroAction() {

		$menu = 'registro';
		$array = UtilitiesAPI::getDefaultContent($menu,$this);
		$array['mensaje'] = 'Usuario registrado exitosamente...Ya puede iniciar sesi&oacute;n, ahora podr&aacute; chequear el estado de sus solicitudes a trav&eacute;s del sistema...';
		$array['titulo'] = 'Usuario Registrado';
		$array['url'] = $this -> generateUrl('proyecto_front_registro');
		$array['cabecera1'] = 'Registro';
		$array['cabecera2'] = 'de usuarios';
		
		return UsersController::procesar($array,$this);
	}
	public static function procesar($array,$class){

		if($array['menu'] == 'registro')$data = new Usuario();
		else $data = $array['usuario'];
		
		$form = $class -> createFormBuilder($data) -> add('nombre', 'text') -> add('apellido', 'text') -> add('email', 'text') -> add('username', 'text') -> add('password', 'repeated', array('first_name' => 'password', 'second_name' => 'confirm', 'type' => 'password', )) -> add('email', 'email') -> add('descripcion', 'textarea') -> add('file') -> getForm();

		if ($class -> getRequest() -> isMethod('POST')) {
			$form -> bind($class -> getRequest());

			if ($form -> isValid()) {

				$em = $class -> getDoctrine() -> getManager();
				$factory = $class -> get('security.encoder_factory');
				$encoder = $factory -> getEncoder($data);
				$password = $encoder -> encodePassword($data -> getPassword(), $data -> getSalt());
				$data -> setPassword($password);
				$em -> persist($data);
				$em -> flush();
				return $class -> render('ProyectoFrontBundle:Helpers:mensaje.html.twig', $array);
			}
		}

		$array['form'] = $form -> createView();
		return $class -> render('ProyectoFrontBundle:Users:cuenta.html.twig', $array);
	}

	public function entradaAction() {
		
		$usuario = UtilitiesAPI::getActiveUser($this);
		echo 'Bienvenido a tu entrada'.$usuario->getUsername();
		exit;
		$array = array();
		return $this -> render('ProyectoFrontBundle:Default:inicio.html.twig', $array);
	}

}
