<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 21/11/15
 */

namespace Curso\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * @ORM\Entity(repositoryClass="Curso\CursoBundle\Entity\CursoRepository")
 * @ORM\Table(name="curso")
 */
class Curso
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $nombre;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank()
     */
    protected $descripcion;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $fechai;
    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    protected $fechaf;

    /**
     * @ORM\Column(type="time")
     * @Assert\NotBlank()
     */
    protected $hora;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $direccion;

    /**
     * @ORM\ManyToOne(targetEntity="Profesor", inversedBy="cursos", cascade={"persist"})
     * @ORM\JoinColumn(name="profesor_id", referencedColumnName="id")
     */
    protected $profesor;

    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="cursos")
     * @ORM\JoinTable(
     *      name="curso_usuario",
     *      joinColumns={@ORM\JoinColumn(name="curso_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")}
     *      )
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
     * Set nombre
     *
     * @param string $nombre
     * @return Curso
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get nombre
     *
     * @return string 
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set descripcion
     *
     * @param string $descripcion
     * @return Curso
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
     * Set fechai
     *
     * @param \DateTime $fechai
     * @return Curso
     */
    public function setFechai($fechai)
    {
        $this->fechai = $fechai;

        return $this;
    }

    /**
     * Get fechai
     *
     * @return \DateTime 
     */
    public function getFechai()
    {
        return $this->fechai;
    }

    /**
     * Set fechaf
     *
     * @param \DateTime $fechaf
     * @return Curso
     */
    public function setFechaf($fechaf)
    {
        $this->fechaf = $fechaf;

        return $this;
    }

    /**
     * Get fechaf
     *
     * @return \DateTime 
     */
    public function getFechaf()
    {
        return $this->fechaf;
    }

    /**
     * Set hora
     *
     * @param \DateTime $hora
     * @return Curso
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
     * Set direccion
     *
     * @param string $direccion
     * @return Curso
     */
    public function setDireccion($direccion)
    {
        $this->direccion = $direccion;

        return $this;
    }

    /**
     * Get direccion
     *
     * @return string 
     */
    public function getDireccion()
    {
        return $this->direccion;
    }

    /**
     * Set profesor
     *
     * @param \Curso\CursoBundle\Entity\Profesor $profesor
     * @return Curso
     */
    public function setProfesor(Profesor $profesor = null)
    {
        $this->profesor = $profesor;

        return $this;
    }

    /**
     * Get profesor
     *
     * @return \Curso\CursoBundle\Entity\Profesor 
     */
    public function getProfesor()
    {
        return $this->profesor;
    }

    /**
     * Add usuarios
     *
     * @param \Curso\CursoBundle\Entity\Usuario $usuarios
     * @return Curso
     */
    public function addUsuario(Usuario $usuarios)
    {
        $this->usuarios[] = $usuarios;

        return $this;
    }

    /**
     * Remove usuarios
     *
     * @param \Curso\CursoBundle\Entity\Usuario $usuarios
     */
    public function removeUsuario(Usuario $usuarios)
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

    public function  __toString()
    {
        return $this->nombre;
    }


}
