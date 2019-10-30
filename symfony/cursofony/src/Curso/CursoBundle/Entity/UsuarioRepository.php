<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 21/11/15
 */

namespace Curso\CursoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class UsuarioRepository extends EntityRepository
{
    public function listaAlfabeticamente()
    {
        $query = 'SELECT u FROM Curso\CursoBundle\Entity\Usuario u ORDER BY u.nombre ASC';
        return $this->getEntityManager()->createQuery($query)->getResult();
    }
//
//    public function misCursos()
//    {
//        $query = "SELECT p FROM Curso\CursoBundle\Entity\Usuario u JOIN u.cursos p WHERE p.id='8'";
//        return $this->getEntityManager()->createQuery($query)->getResult();
//    }
}