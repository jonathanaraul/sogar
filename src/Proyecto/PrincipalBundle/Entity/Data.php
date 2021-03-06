<?php

namespace Proyecto\PrincipalBundle\Entity;
use Symfony\Component\HttpFoundation\File\UploadedFile;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Data
 *
 * @ORM\Table(name="data")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 */
class Data {
	/**
	 * @var integer
	 *
	 * @ORM\Column(name="id", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="IDENTITY")
	 */
	private $id;

	/**
	 * @var \User
	 *
	 * @ORM\ManyToOne(targetEntity="User")
	 * @ORM\JoinColumns({
	 *   @ORM\JoinColumn(name="user", referencedColumnName="id")
	 * })
	 */
	private $user;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="titulo", type="text", nullable=false)
	 */
	private $titulo;

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
	 * @ORM\Column(name="habilitado", type="boolean", nullable=true)
	 */
	private $habilitado;

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
		$directorio = 'subidas';
		// get rid of the __DIR__ so it doesn't screw up
		// when displaying uploaded doc/image in the view.
		if ($this -> categoria -> getTipo() == 0)
			$directorio = 'entradas';
		else if ($this -> categoria -> getTipo() == 1)
			$directorio = 'archivos';
		else if ($this -> categoria -> getTipo() == 2)
			$directorio = 'imagenes';
		else if ($this -> categoria -> getTipo() == 3)
			$directorio = 'correo';

		return 'uploads/' . $directorio;
	}

	/**
	 * Get id
	 *
	 * @return integer
	 */
	public function getId() {
		return $this -> id;
	}

	/**
	 * Set user
	 *
	 * @param \Proyecto\PrincipalBundle\Entity\User $user
	 * @return Data
	 */
	public function setUser(\Proyecto\PrincipalBundle\Entity\User $user = null) {
		$this -> user = $user;

		return $this;
	}

	/**
	 * Get user
	 *
	 * @return \Proyecto\PrincipalBundle\Entity\User
	 */
	public function getUser() {
		return $this -> user;
	}

	/**
	 * Set titulo
	 *
	 * @param string $titulo
	 * @return Data
	 */
	public function setTitulo($titulo) {
		$this -> titulo = $titulo;

		return $this;
	}

	/**
	 * Get titulo
	 *
	 * @return string
	 */
	public function getTitulo() {
		return $this -> titulo;
	}

	/**
	 * Set mensaje
	 *
	 * @param string $mensaje
	 * @return Data
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
	 * @return Data
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
	 * @return Data
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
	 * Set habilitado
	 *
	 * @param boolean $habilitado
	 * @return Data
	 */
	public function setHabilitado($habilitado) {
		$this -> habilitado = $habilitado;

		return $this;
	}

	/**
	 * Get habilitado
	 *
	 * @return boolean
	 */
	public function getHabilitado() {
		return $this -> habilitado;
	}

	/**
	 * Set categoria
	 *
	 * @param \Proyecto\PrincipalBundle\Entity\Categoria $categoria
	 * @return Data
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

	/*
	 public function upload()
	 {
	 // the file property can be empty if the field is not required
	 if (null === $this->getFile()) {
	 return;
	 }

	 // use the original file name here but you should
	 // sanitize it at least to avoid any security issues

	 // move takes the target directory and then the
	 // target filename to move to
	 $this->getFile()->move(
	 $this->getUploadRootDir(),
	 $this->getFile()->getClientOriginalName()
	 );

	 // set the path property to the filename where you've saved the file
	 $this->adjunto = $this->getFile()->getClientOriginalName();

	 // clean up the file property as you won't need it anymore
	 $this->file = null;
	 }*/
}
