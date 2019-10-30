<?php
namespace Desymfony\DesymfonyBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="ponencia")
 */
class Ponencia
{
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
}
