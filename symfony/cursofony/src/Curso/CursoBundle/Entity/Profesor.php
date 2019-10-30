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
 * @ORM\Entity(repositoryClass="Curso\CursoBundle\Entity\ProfesorRepository")
 * @ORM\Table(name="profesor")
 */
class Profesor
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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $apellidos;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     */
    protected $titulo;

    /**
     * @ORM\Column(type="text")
     */
    protected $biografia;

    /**
     * @ORM\Column(type="string")
     */
    protected $telefono;

    /**
     * @ORM\Column(type="string")
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\OneToMany(targetEntity="Curso", mappedBy="profesor", cascade={"persist"})
     */
    protected $cursos;


    /**
     * Constructor
     */
    public function __construct()
    {
        $this->cursos = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Profesor
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
     * Set apellidos
     *
     * @param string $apellidos
     * @return Profesor
     */
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    /**
     * Get apellidos
     *
     * @return string 
     */
    public function getApellidos()
    {
        return $this->apellidos;
    }

    /**
     * Set titulo
     *
     * @param string $titulo
     * @return Profesor
     */
    public function setTitulo($titulo)
    {
        $this->titulo = $titulo;

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
     * Set biografia
     *
     * @param string $biografia
     * @return Profesor
     */
    public function setBiografia($biografia)
    {
        $this->biografia = $biografia;

        return $this;
    }

    /**
     * Get biografia
     *
     * @return string 
     */
    public function getBiografia()
    {
        return $this->biografia;
    }

    /**
     * Set telefono
     *
     * @param string $telefono
     * @return Profesor
     */
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * Get telefono
     *
     * @return string 
     */
    public function getTelefono()
    {
        return $this->telefono;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Profesor
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string 
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Add cursos
     *
     * @param \Curso\CursoBundle\Entity\Curso $cursos
     * @return Profesor
     */
    public function addCurso(Curso $cursos)
    {
        $this->cursos[] = $cursos;

        return $this;
    }

    /**
     * Remove cursos
     *
     * @param \Curso\CursoBundle\Entity\Curso $cursos
     */
    public function removeCurso(Curso $cursos)
    {
        $this->cursos->removeElement($cursos);
    }

    /**
     * Get cursos
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getCursos()
    {
        return $this->cursos;
    }

    public function  __toString()
    {
        return $this->nombre ." ". $this->apellidos;
    }
}
