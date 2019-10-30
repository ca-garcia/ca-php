<?php
namespace Desymfony\DesymfonyBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\Role\Role;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\ExecutionContextInterface;
use  Desymfony\DesymfonyBundle\Validator\Constraints as MisAssert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;


/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 * @UniqueEntity("email")
 */
class Usuario implements UserInterface
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="IDENTITY")
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
     * @MisAssert\DNI()
     */
    protected $dni;
    /**
     * @ORM\Column(type="string")
     * @Assert\Choice(choices = {"LaHab", "Stgo"})
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
     * @Assert\Length(min = 6)
     */
    protected $password;
    /**
     * @ORM\ManyToMany(targetEntity="Ponencia", mappedBy="usuarios")
     */
    protected $ponencias;

    /**
     * Constructor
     */
    public function __construct()
    {
        $this->ponencias = new \Doctrine\Common\Collections\ArrayCollection();
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
     * Get password
     *
     * @return string 
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Add ponencias
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias
     * @return Usuario
     */
    public function addPonencia(\Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias)
    {
        $this->ponencias[] = $ponencias;

        return $this;
    }

    /**
     * Remove ponencias
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias
     */
    public function removePonencia(\Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias)
    {
        $this->ponencias->removeElement($ponencias);
    }

    /**
     * Get ponencias
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getPonencias()
    {
        return $this->ponencias;
    }

   /* public function esDniValido(ExecutionContextInterface $context)
    {
        $dni = $this->getDni();
        if (strlen($dni) != 11)
        {
            $context->addViolationAt('dni', 'El DNI introducido no tiene 11 dígitos', array(), null);
            return;
        }

        if (! preg_match("/^[0-9]{11}$/", $dni))
        {
            $context->addViolationAt('dni', 'El DNI introducido contiene caracteres distintos de dígitos', array(), null);
            return;
        }
    }
*/


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
        return false;
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
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
        return false;
    }

    public function __toString()
    {
        return $this->nombre." ".$this->apellidos;
    }

}
