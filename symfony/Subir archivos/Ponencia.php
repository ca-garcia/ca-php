<?php
/**
 * Created by JetBrains PhpStorm.
 * User: joe
 * Date: 9/03/14
 * Time: 05:07 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Desymfony\DesymfonyBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\File;

/**
 * @ORM\Entity
 * @ORM\Table(name="ponencia")
 */
class Ponencia {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    protected $id;
    /**
     * @ORM\Column(type="string")
     */
    protected $titulo;
    /**
     * @ORM\Column(type="string")
     */
    protected $slug;
    /**
     * @ORM\Column(type="text")
     */
    protected $descripcion;
    /**
     * @ORM\Column(type="date")
     */
    protected $fecha;
    /**
     * @ORM\Column(type="time")
     */
    protected $hora;
    /**
     * @ORM\Column(type="integer")
     */
    protected $duracion;
    /**
     * @ORM\Column(type="string", length=2)
     */
    protected $idioma;
    /**
     * @ORM\ManyToOne(targetEntity="Ponente", inversedBy="ponencias")
     * @ORM\JoinColumn(name="ponente_id", referencedColumnName="id")
     */
    protected $ponente;
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="ponencias")
     * @ORM\JoinTable(name="ponencia_usuario",
     *      joinColumns={@ORM\JoinColumn(name="ponencia_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")})
     */
    protected  $usuarios;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->usuarios = new \Doctrine\Common\Collections\ArrayCollection();
    }
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Ponencia
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;
        $this->slug = $titulo;

        return $this;
    }

    /**
     * Get titulo
     *
     * @return string 
     */
    public function getTitulo()
    {
        return $this->titulo;
    }

    /**
     * Set slug
     *
     * @param string $slug
     * @return Ponencia
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    
        return $this;
    }

    /**
     * Get slug
     *
     * @return string 
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Ponencia
     */
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    
        return $this;
    }

    /**
     * Get descripcion
     *
     * @return string 
     */
    public function getDescripcion()
    {
        return $this->descripcion;
    }

    /**
     * Set fecha
     *
     * @param \DateTime $fecha
     * @return Ponencia
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    
        return $this;
    }

    /**
     * Get fecha
     *
     * @return \DateTime 
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Ponencia
     */
    public function setHora($hora)
    {
        $this->hora = $hora;
    
        return $this;
    }

    /**
     * Get hora
     *
     * @return \DateTime 
     */
    public function getHora()
    {
        return $this->hora;
    }

    /**
     * Set duracion
     *
     * @param integer $duracion
     * @return Ponencia
     */
    public function setDuracion($duracion)
    {
        $this->duracion = $duracion;
    
        return $this;
    }

    /**
     * Get duracion
     *
     * @return integer 
     */
    public function getDuracion()
    {
        return $this->duracion;
    }

    /**
     * Set idioma
     *
     * @param string $idioma
     * @return Ponencia
     */
    public function setIdioma($idioma)
    {
        $this->idioma = $idioma;
    
        return $this;
    }

    /**
     * Get idioma
     *
     * @return string 
     */
    public function getIdioma()
    {
        return $this->idioma;
    }

    /**
     * Set ponente
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Ponente $ponente
     * @return Ponencia
     */
    public function setPonente(\Desymfony\DesymfonyBundle\Entity\Ponente $ponente = null)
    {
        $this->ponente = $ponente;
    
        return $this;
    }

    /**
     * Get ponente
     *
     * @return \Desymfony\DesymfonyBundle\Entity\Ponente 
     */
    public function getPonente()
    {
        return $this->ponente;
    }

    /**
     * Add usuarios
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Usuario $usuarios
     * @return Ponencia
     */
    public function addUsuario(\Desymfony\DesymfonyBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;
    
        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(\Desymfony\DesymfonyBundle\Entity\Usuario $usuarios)
    {
        $this->usuarios->removeElement($usuarios);
    }

    /**
     * Get usuarios
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getUsuarios()
    {
        return $this->usuarios;
    }
	
	/*
	-------------- NUEVOS ATRIBUTOS Y MÉTODOS RELACIONADOS CON SUBIRLE UN ARCHIVO A --------------
	-------------- LA PONENCIA, CONSULTAR MÁS SOBRE ESTO EN LOS PDF--------------
	-------------- Symfony_metabook_2.1 PÁGINA 298 Y Symfony2_v2.0.1 PÁGINA 294
	*/
	
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
	protected $rutaImg;
    /**
     * @Assert\File(maxSize="6000000")
     */
	protected $fichero;
	
	public function getAbsolutePath()
	{
		return null === $this->rutaImg ? null : $this->getUploadRootDir().'/'.$this->rutaImg;
	}
	
	public function getWebPath()
	{
		return null === $this->rutaImg ? null : $this->getUploadDir().'/'.$this->rutaImg;
	}

	protected function getUploadRootDir()
	{
		// la ruta absoluta al directorio dónde se deben guardar los documentos cargados
		return __DIR__.'/../../../../web/'.$this->getUploadDir();
	}
	protected function getUploadDir()
	{
		// se libra del __DIR__ para no desviarse al mostrar ‘doc/image‘ en la vista.
		return 'cargas/imagenes';
	}	
	
	public function subirArchivo()
	{
		// la propiedad ’fichero’ puede estar vacía si el campo no es obligatorio
		if (null === $this->fichero) {
		return;
		}
		// aquí utilizamos el nombre de archivo original pero lo deberías
		// desinfectar por lo menos para evitar cualquier problema de seguridad
		// ’move’ toma el directorio y nombre de archivo destino al cual trasladarlo
		$this->fichero->move($this->getUploadRootDir(), $this->fichero->getClientOriginalName());
		// fija la propiedad ’path’ al nombre de archivo donde se guardó el archivo
		$this->setRutaImg($this->fichero->getClientOriginalName());
		// limpia la propiedad ’file’ ya que no la necesitas más
		$this->fichero = null;
	}	
	
	public function getFichero()
	{
		return $this->fichero;
	}

	public function setFichero($fichero)
	{
		$this->fichero = $fichero;
	}	
	
	public function setRutaImg($ruta)
	{
		$this->rutaImg = $ruta;
	}
	
}