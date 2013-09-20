<?php

namespace Proyecto\PrincipalBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Proyecto\PrincipalBundle\Entity\Categoria;

/**
 * Salida
 *
 * @ORM\Table(name="salida")
 * @ORM\Entity
 */
class Salida
{
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;
	/**
	 * @var \Usuario
	 *
	 * @ORM\ManyToOne(targetEntity="Usuario")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="usuario", referencedColumnName="id")
	 * })
	 */
	private $usuario;

	/**
	 * @var \Entrada
	 *
	 * @ORM\ManyToOne(targetEntity="Entrada")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="entrada", referencedColumnName="id")
	 * })
	 */
	private $entrada;


	/**
	 * @var string
	 *
	 * @ORM\Column(name="mensaje", type="text", nullable=false)
	 */
	private $mensaje;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="adjunto", type="text", nullable=true)
	 */
	private $adjunto;

	/**
	 * @var \DateTime
	 *
	 * @ORM\Column(name="fecha", type="datetime", nullable=false)
	 */
	private $fecha;

	/**
	 * @var boolean
	 *
	 * @ORM\Column(name="visible", type="boolean", nullable=true)
	 */
	private $visible;

	/**
	 * @var \Categoria
	 *
	 * @ORM\ManyToOne(targetEntity="Categoria")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="categoria", referencedColumnName="id")
	 * })
	 */
	private $categoria;

	/**
	 * @Assert\File(maxSize="6000000")
	 */
	private $file;
	private $temp;


	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this -> id;
	}

	/**
	 * Set usuario
	 *
	 * @param \Proyecto\PrincipalBundle\Entity\Usuario $usuario
	 * @return Salida
	 */
	public function setUsuario(\Proyecto\PrincipalBundle\Entity\Usuario $usuario = null) {
		$this -> usuario = $usuario;

		return $this;
	}

	/**
	 * Get usuario
	 *
	 * @return \Proyecto\PrincipalBundle\Entity\Usuario
	 */
	public function getUsuario() {
		return $this -> usuario;
	}

	/**
	 * Set entrada
	 *
	 * @param \Proyecto\PrincipalBundle\Entity\Entrada $entrada
	 * @return Salida
	 */
	public function setEntrada(\Proyecto\PrincipalBundle\Entity\Entrada $entrada = null) {
		$this -> entrada = $entrada;

		return $this;
	}

	/**
	 * Get entrada
	 *
	 * @return \Proyecto\PrincipalBundle\Entity\Entrada
	 */
	public function getEntrada() {
		return $this -> entrada;
	}
	/**
	 * Set mensaje
	 *
	 * @param string $mensaje
	 * @return Salida
	 */
	public function setMensaje($mensaje) {
		$this -> mensaje = $mensaje;

		return $this;
	}

	/**
	 * Get mensaje
	 *
	 * @return string
	 */
	public function getMensaje() {
		return $this -> mensaje;
	}

	/**
	 * Set adjunto
	 *
	 * @param string $adjunto
	 * @return Salida
	 */
	public function setAdjunto($adjunto) {
		$this -> adjunto = $adjunto;

		return $this;
	}

	/**
	 * Get adjunto
	 *
	 * @return string
	 */
	public function getAdjunto() {
		return $this -> adjunto;
	}

	/**
	 * Set fecha
	 *
	 * @param \DateTime $fecha
	 * @return Salida
	 */
	public function setFecha($fecha) {
		$this -> fecha = $fecha;

		return $this;
	}

	/**
	 * Get fecha
	 *
	 * @return \DateTime
	 */
	public function getFecha() {
		return $this -> fecha;
	}

	/**
	 * Set visible
	 *
	 * @param boolean $visible
	 * @return Salida
	 */
	public function setVisible($visible) {
		$this -> visible = $visible;

		return $this;
	}

	/**
	 * Get visible
	 *
	 * @return boolean
	 */
	public function getVisible() {
		return $this -> visible;
	}

	/**
	 * Set categoria
	 *
	 * @param \Proyecto\PrincipalBundle\Entity\Categoria $categoria
	 * @return Salida
	 */
	public function setCategoria(\Proyecto\PrincipalBundle\Entity\Categoria $categoria = null) {
		$this -> categoria = $categoria;

		return $this;
	}

	/**
	 * Get categoria
	 *
	 * @return \Proyecto\PrincipalBundle\Entity\Categoria
	 */
	public function getCategoria() {
		return $this -> categoria;
	}

	/**
	 * Sets file.
	 *
	 * @param UploadedFile $file
	 */
	public function setFile(UploadedFile $file = null) {
		$this -> file = $file;
		// check if we have an old image path
		if (isset($this -> adjunto)) {
			// store the old name to delete after the update
			$this -> temp = $this -> adjunto;
			$this -> adjunto = null;
		} else {
			$this -> adjunto = 'initial';
		}
	}

	/**
	 * @ORM\PrePersist()
	 * @ORM\PreUpdate()
	 */
	public function preUpload() {
		if (null !== $this -> getFile()) {
			// do whatever you want to generate a unique name
			$filename = sha1(uniqid(mt_rand(), true));
			$this -> adjunto = $filename . '.' . $this -> getFile() -> guessExtension();
		}
	}

	/**
	 * @ORM\PostPersist()
	 * @ORM\PostUpdate()
	 */
	public function upload() {
		if (null === $this -> getFile()) {
			return;
		}

		// if there is an error when moving the file, an exception will
		// be automatically thrown by move(). This will properly prevent
		// the entity from being persisted to the database on error
		$this -> getFile() -> move($this -> getUploadRootDir(), $this -> adjunto);

		// check if we have an old image
		if (isset($this -> temp)) {
			// delete the old image
			unlink($this -> getUploadRootDir() . '/' . $this -> temp);
			// clear the temp image path
			$this -> temp = null;
		}
		$this -> file = null;
	}

	/**
	 * @ORM\PostRemove()
	 */
	public function removeUpload() {
		if ($file = $this -> getAbsolutePath()) {
			unlink($file);
		}
	}

	public function getMes(){
		$mes = intval($this->fecha -> format('m')) - 1;
		$meses =array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
		return $meses[$mes];
	}
	
	public function getTextoCorto($dimension){
		 $texto =  $this->mensaje;
		 $final = '';
		 $auxiliares = explode(' ', $texto);
		 
		 for ($i=0; $i < count($auxiliares) ; $i++) { 	 
			 $final.= " ".$auxiliares[$i];
			 if($dimension < strlen($final)) break;
		 }
		 $final.= '...';
		 return $final;
	}
	/**
	 * Get file.
	 *
	 * @return UploadedFile
	 */
	public function getFile() {
		return $this -> file;
	}

	public function getAbsolutePath() {
		return null === $this -> adjunto ? null : $this -> getUploadRootDir() . '/' . $this -> adjunto;
	}

	public function getWebPath() {
		return null === $this -> adjunto ? null : $this -> getUploadDir() . '/' . $this -> adjunto;
	}

	protected function getUploadRootDir() {
		// the absolute directory path where uploaded
		// documents should be saved
		return __DIR__ . '/../../../../web/' . $this -> getUploadDir();
	}

	protected function getUploadDir() {
		$directorio = 'salida';
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		/*if ($this -> categoria -> getTipo() == 0)
			$directorio = 'entradas';
		else if ($this -> categoria -> getTipo() == 1)
			$directorio = 'archivos';
		else if ($this -> categoria -> getTipo() == 2)
			$directorio = 'imagenes';
		else if ($this -> categoria -> getTipo() == 3)
			$directorio = 'correo';*/

		return 'front/uploads/' . $directorio;
	}
}