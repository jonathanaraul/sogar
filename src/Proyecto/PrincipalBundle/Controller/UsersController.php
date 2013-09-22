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
use Symfony\Component\Security\Core\Util\StringUtils;
use Proyecto\PrincipalBundle\Entity\User;

class UsersController extends Controller {
	
	public function modificarAction() {
		$peticion = $this -> getRequest();
		$doctrine = $this -> getDoctrine();
		$post = $peticion -> request;

		//INICIALIZAR VARIABLES
		$tipo = $post -> get("tipo");
		$id = intval($post -> get("id"));
		$estatus = intval($post -> get("estatus"));
		$em = $this->getDoctrine()->getManager();

		$usuario = $em -> getRepository('ProyectoPrincipalBundle:Usuario') -> find($id);
		
		if($tipo == 'jerarquia'){
			$usuario->setJerarquia($estatus);
   
		}
		else{
			$usuario->setIsActive($estatus);
		}
		$em->flush();

		$respuesta = new response(json_encode(array('estado' => true)));
		$respuesta -> headers -> set('content_type', 'aplication/json');
		return $respuesta;
	}


	public function listadoAction() {
                                                      
		$firstArray = UtilitiesAPI::getDefaultContent('Usuarios', 'Listado','Listado', 'Ascienda/Degrade o Active/Desactive usuarios en el sistema', $this);
		$secondArray = array();

		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT e
    								 FROM ProyectoPrincipalBundle:Usuario e
    								');

		$secondArray['objects'] = $query -> getResult();
		
		
		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Users:listado.html.twig', $array);
	}
	
	public function accesoAction() {

		$error = NULL;
		$ultimo_nombreusuario = null;

		$peticion = $this -> getRequest();
		$sesion = $peticion -> getSession();
		// obtiene el error de inicio de sesión si lo hay
		if ($peticion -> attributes -> has(SecurityContext::AUTHENTICATION_ERROR))
			$error = $peticion -> attributes -> get(SecurityContext::AUTHENTICATION_ERROR);
		else
			$error = $sesion -> get(SecurityContext::AUTHENTICATION_ERROR);

		$firstArray = UtilitiesAPI::getDefaultContent('Usuarios', 'Acceso', 'Acceso', 'Ingrese su nombre de usuario y su contraseña', $this);
		$secondArray = array('ultimo_nombreusuario' => $sesion -> get(SecurityContext::LAST_USERNAME), 'error' => $error);

		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Users:acceso.html.twig', $array);
	}

	public function cuentaGuardarAction() {
		$peticion = $this -> getRequest();
		$doctrine = $this -> getDoctrine();
		$post = $peticion -> request;
		//INICIALIZAR VARIABLES
		$tipo = $post -> get("tipo");
		//Saber si se actualiza o si se crea
		$nombre = trim(strtolower($post -> get("nombre")));
		$apellido = trim(strtolower($post -> get("apellido")));
		$nombreusuario = trim($post -> get("nombredeusuario"));
		$contrasenia = $post -> get("password");
		$contrasenia2 = $post -> get("password2");
		$sexo = $post -> get("sexomasculino");
		$email = $post -> get("email");
		$descripcion = htmlentities(addslashes($post -> get("descripcion")));
		$path = "admin/images/avatar-man.png";

		if ($sexo == 'false'){
			$path = "admin/images/avatar-woman.png";
			$sexo = 1;
		}
		else{
			$sexo = 0;
		}
		

		$estado = StringUtils::equals($contrasenia, $contrasenia2);
		if ($estado == true)
			UtilitiesAPI::procesaUsuario($tipo, $nombre, $apellido, $nombreusuario, $contrasenia, $sexo, $email, $descripcion, $path, $this);

		$respuesta = new response(json_encode(array('estado' => $estado)));
		$respuesta -> headers -> set('content_type', 'aplication/json');
		return $respuesta;
	}

	public function perfilAction() {
		$user = UtilitiesAPI::getActiveUser($this);	
		$auxiliar = array('descripcionusuario' => stripcslashes(html_entity_decode($user -> getDescripcion())));

		$firstArray = UtilitiesAPI::getDefaultContent('Usuarios', 'Perfil','Perfil', 'Lea o edite su perfil', $this);
		$secondArray = array('auxiliar'=>$auxiliar);

		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Users:cuenta.html.twig', $array);
	}

	public function registroAction() {
		$firstArray = UtilitiesAPI::getDefaultContent('Usuarios', 'Registro','Registro', 'Rellene los siguientes campos para acceder al sistema', $this);
		$secondArray = array();

		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Users:cuenta.html.twig', $array);
	}

}
