<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 21/11/15
 */

namespace Curso\CursoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class ProfesorRepository extends EntityRepository
{
    public function getAllAlfabeticamente()
    {
        $query = 'SELECT p FROM Curso\CursoBundle\Entity\Profesor p ORDER BY p.nombre ASC';
        return $this->getEntityManager()->createQuery($query)->getResult();
    }
//    public function conPonenciaEs()
//    {
//        $query = "SELECT p FROM Desymfony\DesymfonyBundle\Entity\Ponente p JOIN p.ponencias o WHERE o.idioma='es'";
//        return $this->getEntityManager()->createQuery($query)->getResult();
//    }

}