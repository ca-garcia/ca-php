<?php
namespace Desymfony\DesymfonyBundle\Entity;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="Desymfony\DesymfonyBundle\Entity\PonenteRepository")
 * @ORM\Table(name="ponente")
 */
class Ponente
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
    protected $nombre;
    /**
     * @ORM\Column(type="string")
     */
    protected $apellidos;
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
     */
    protected $url;
    /**
     * @ORM\Column(type="string")
     */
    protected $email;
    /**
     * @ORM\Column(type="string")
     */
    protected $twitter;
    /**
     * @ORM\Column(type="string")
     */
    protected $linkedin;
    /**
     * @ORM\OneToMany(targetEntity="Ponencia", mappedBy="ponente")
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
     * @return Ponente
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
     * @return Ponente
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
     * Set biografia
     *
     * @param string $biografia
     * @return Ponente
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
     * @return Ponente
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
     * Set url
     *
     * @param string $url
     * @return Ponente
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string 
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set email
     *
     * @param string $email
     * @return Ponente
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
     * Set twitter
     *
     * @param string $twitter
     * @return Ponente
     */
    public function setTwitter($twitter)
    {
        $this->twitter = $twitter;

        return $this;
    }

    /**
     * Get twitter
     *
     * @return string 
     */
    public function getTwitter()
    {
        return $this->twitter;
    }

    /**
     * Set linkedin
     *
     * @param string $linkedin
     * @return Ponente
     */
    public function setLinkedin($linkedin)
    {
        $this->linkedin = $linkedin;

        return $this;
    }

    /**
     * Get linkedin
     *
     * @return string 
     */
    public function getLinkedin()
    {
        return $this->linkedin;
    }

    /**
     * Add ponencias
     *
     * @param \Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias
     * @return Ponente
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

    public function  __toString()
    {
        return $this->nombre." ".$this->apellidos;
    }


}
