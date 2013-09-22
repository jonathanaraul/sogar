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
use Proyecto\PrincipalBundle\Entity\Entrada;
use Proyecto\PrincipalBundle\Entity\Salida;
use Doctrine\ORM\EntityRepository;

class CorreoController extends Controller {

	
	public function listadoAction() {

		$firstArray = UtilitiesAPI::getDefaultContent('Correo', 'Listado de mensajes recibidos', 'Listado de mensajes recibidos', 'Seleccione el correo a leer', $this);
		$secondArray = array();

		$em = $this->getDoctrine()->getManager();
		$query = $em -> createQuery('SELECT e
    								 FROM ProyectoPrincipalBundle:Entrada e
    								 ORDER BY e.fecha DESC');

		$secondArray['objects'] = $query -> getResult();
		
		
		$array = array_merge($firstArray, $secondArray);
		return $this -> render('ProyectoPrincipalBundle:Correo:listado.html.twig', $array);
	}
	
	public function entradaAction($id) {
		$id = intval($id);
		$firstArray = UtilitiesAPI::getDefaultContent('Correo', 'Ticket de consulta', 'Ticket de consulta', 'Puede leer y/o responder el siguiente elemento.', $this);

		$secondArray = array();
		$em = $this->getDoctrine()->getManager();
		
		$secondArray['object'] = $em -> getRepository('ProyectoPrincipalBundle:Entrada') -> find($id);
		$secondArray['object']->setLeido(1);
   		$em->flush();
		
		$secondArray['url'] = $this -> generateUrl('proyecto_principal_correo_entrada',array('id' => $secondArray['object'] ->getId()));

		$query = $em -> createQuery('SELECT u
    								 FROM ProyectoPrincipalBundle:Entrada e,
										  ProyectoPrincipalBundle:Usuario u   								 
   	 								 WHERE u.email = e.email and
   	 								       e.email = :email
    								') 
    				 -> setParameter('email', $secondArray['object']->getEmail());

		$secondArray['usuarioEntrada'] = $query -> getOneOrNullResult();
		$query = $em -> createQuery('SELECT s
    								 FROM   ProyectoPrincipalBundle:Salida s, 
    								 		ProyectoPrincipalBundle:Entrada e
								
   	 								 WHERE s.entrada = e.id and
   	 								       e.id = :entrada
   	 								 ORDER BY s.fecha DESC
    								') 
    				 -> setParameter('entrada', $secondArray['object']);
		$secondArray['respuestas'] = $query -> getResult();			 
		
		$array = array_merge($firstArray, $secondArray);
		
		$data = new Salida();
		$tipo = 4;
		$form = $this -> createFormBuilder($data) 
				-> add('mensaje', 'textarea') 
				-> add('categoria', 'entity', array('class' => 'ProyectoPrincipalBundle:Categoria', 'query_builder' => function(EntityRepository $er) use ($tipo) {
			return $er -> createQueryBuilder('sc') -> where('sc.tipo = :tipo') -> setParameter('tipo', $tipo);
		}, )) 
				-> add('file') 
				-> getForm();

		if ($this -> getRequest() -> isMethod('POST')) {
			$form -> bind($this -> getRequest());

			if ($form -> isValid()) {
				
				$em = $this -> getDoctrine() -> getManager();
				$data -> setUsuario(UtilitiesAPI::getActiveUser($this));
				$data -> setFecha(new \DateTime());
				$data -> setVisible(1);
				$data -> setEntrada($secondArray['object']);
				$data -> setFecha(new \DateTime());
				$em -> persist($data);
				$em -> flush();

				$secondArray['object']->setRespondido(1);
   				$em->flush();
				
				$firstArray = UtilitiesAPI::getDefaultContent('Correo','Ticket de consulta','Guardado', 'Su mensaje fue enviado exitosamente...', $this);
				$secondArray = array('object' => null);
				$array = array_merge($firstArray, $secondArray);

				return $this -> render('ProyectoPrincipalBundle:Helpers:mensaje.html.twig', $array);
			}
		}

		$array['form'] = $form -> createView();
		return $this -> render('ProyectoPrincipalBundle:Correo:entrada.html.twig', $array);
	}
}
