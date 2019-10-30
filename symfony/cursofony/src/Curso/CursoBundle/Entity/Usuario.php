<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 21/11/15
 */

namespace Curso\CursoBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;//no se puede quitar.

/**
 * @ORM\Entity(repositoryClass="Curso\CursoBundle\Entity\UsuarioRepository")
 * @ORM\Table(name="usuario")
 * @UniqueEntity("email")
 * @Assert\Callback(methods={"esDniValido", "telefonoValido"})
 */
class Usuario implements UserInterface
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
    protected $dni;

    /**
     * @ORM\Column(type="string")
     */
    protected $direccion;

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
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min = 6)
     */
    protected $password;

    /**
     * @ORM\ManyToMany(targetEntity="Curso", mappedBy="usuarios")
     */
    protected $cursos;


    public function esDniValido(ExecutionContextInterface $context)
    {
        $dni = $this->getDni();
        if (strlen($dni) != 11)
        {
            $context->addViolationAt('dni', 'El DNI introducido no tiene 11 dígitos.', array(), null);
            return;
        }

        if (! preg_match("/^[0-9]{11}$/", $dni))
        {
            $context->addViolationAt('dni', 'El DNI introducido contiene caracteres distintos de dígitos.', array(), null);
            return;
        }
    }

    /**
     * @param ExecutionContextInterface $context
     */
    public function telefonoValido(ExecutionContextInterface $context)
    {
        $phone = $this->getTelefono();

        if (strlen($phone) < 6)
        {
            $context->addViolationAt('telefono', 'El Telefono introducido no tiene 6 dígitos.', array(), null);
            return;
        }
//        $length = strval(strlen($phone));
//        $length = strlen($phone);
        $length = (string)strlen($phone);

//        if (! preg_match("/^[0-9]{".$length."}$/", $phone))
        if (! preg_match("/^[0-9]+$/", $phone))//el + significa 1 o mas ocurrencias.
        {
            $context->addViolationAt('telefono', 'El Telefono introducido contiene caracteres distintos de dígitos.', array(), null);
            return;
        }
    }

    /**
     * Returns the roles granted to the user.
     *
     * <code>
     * public function getRoles()
     * {
     *     return array('ROLE_USER');
     * }
     * </code>
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return Role[] The user roles
     */
    public function getRoles()
    {
        // TODO: Implement getRoles() method.
        return array('ROLE_USER');

    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
        // TODO: Implement getSalt() method.
        return false;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        // TODO: Implement getUsername() method.
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        // TODO: Implement eraseCredentials() method.
        return false;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        // TODO: Implement getPassword() method.
        return $this->password;
    }

    public function  __toString()
    {
        return $this->nombre ." ". $this->apellidos;
    }


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
     * @return Usuario
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
     * @return Usuario
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
     * Set dni
     *
     * @param string $dni
     * @return Usuario
     */
    public function setDni($dni)
    {
        $this->dni = $dni;

        return $this;
    }

    /**
     * Get dni
     *
     * @return string 
     */
    public function getDni()
    {
        return $this->dni;
    }

    /**
     * Set direccion
     *
     * @param string $direccion
     * @return Usuario
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
     * Set telefono
     *
     * @param string $telefono
     * @return Usuario
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
     * @return Usuario
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
     * Set password
     *
     * @param string $password
     * @return Usuario
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Add cursos
     *
     * @param \Curso\CursoBundle\Entity\Curso $cursos
     * @return Usuario
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
}
