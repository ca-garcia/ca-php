Si se tratase de insertar una ponencia con ponente y usuarios que no han sido insertados, se reportará un error:

    public function pruebaBDAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponente = $em->getRepository('DesymfonyBundle:Ponente')
            ->find(5);


        $usuario = new Usuario();
        $usuario->setNombre("Joe");
        $usuario->setApellidos("Perez");
        $usuario->setDni("1111");
        $usuario->setDireccion("Aquí");
        $usuario->setTelefono("555555");
        $usuario->setEmail("joe@gmail.com");
        $usuario->setPassword("prueba");

        $ponente = new Ponente();

        //paso 2
        $ponente->setNombre("Ariel");
        $ponente->setApellidos("Perez");
        $ponente->setBiografia("Natural de Villa Clara");
        $ponente->setTelefono("34435356");
        $ponente->setUrl("http://www.raulCF.com");
        $ponente->setEmail("raulCF@gmail.com");
        $ponente->setLinkedin("http://www.linkedin.com/in/raulCF");
        $ponente->setTwitter("http://www.twitter.com/raulCF");


        //paso 1
        $ponencia = new Ponencia();

        //paso 2
        $ponencia->setTitulo("Introduccion a PHP");
        $ponencia->setDescripcion("Explicación de lo básico de PHP");
        $ponencia->setFecha(new \DateTime('2013-11-25'));
        $ponencia->setHora(new \DateTime('9:00:00'));
        $ponencia->setDuracion(45);
        $ponencia->setIdioma("uk");
        $ponencia->setPonente($ponente);
        $ponencia->addUsuario($usuario);

        //paso 4
        $em->persist($ponencia);


        $em->flush();

        return new Response("Se actualizó");

    }
	
	Solución, en la clase Ponencia:
	
	/**
     * @ORM\ManyToOne(targetEntity="Ponente", inversedBy="ponencias", cascade={"persist"})
     * @ORM\JoinColumn(name="ponente_id", referencedColumnName="id")
     */
    protected $ponente;
    /**
     * @ORM\ManyToMany(targetEntity="Usuario", inversedBy="ponencias", cascade={"persist"})
     * @ORM\JoinTable(name="ponencia_usuario",
     *      joinColumns={@ORM\JoinColumn(name="ponencia_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="usuario_id", referencedColumnName="id")})
     */
    protected  $usuarios;
	
	
	Cuando se trata de eliminar un ponente que está asociado a una ponencia, se reportará un error, si se desea que se elimine la ponencia en cascada, en la clase Ponente:
	
	/**
     * @ORM\OneToMany(targetEntity="Ponencia", mappedBy="ponente", cascade={"remove"})
     */
    protected $ponencias;
	
	Si se trata de romper una asociación desde el lado que no es propietario, por ejemplo desde un usuario eliminarle una ponencia, el código se ejecuta sin notificar nada pero en la práctica no se elimina la relación, por ejemplo:


    public function pruebaBDAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ponencia = $em->getRepository('DesymfonyBundle:Ponencia')
            ->find(5);

        $usuario = $em->getRepository('DesymfonyBundle:Usuario')
            ->find(51);


        $usuario->removePonencia($ponencia);

        $em->flush();

        return new Response("Se actualizó ponencia");

    }

Solución, en la Clase Usuario:

    public function removePonencia(\Desymfony\DesymfonyBundle\Entity\Ponencia $ponencias)
    {
        $this->ponencias->removeElement($ponencias);
        $ponencias->removeUsuario($this);
    }	