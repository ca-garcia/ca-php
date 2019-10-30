<?php
/**
 * Created by PhpStorm.
 * User: Carlos
 * Date: 11/21/15
 */

namespace Curso\CursoBundle\Entity;

use Doctrine\ORM\EntityRepository;

class CursoRepository extends EntityRepository{

    public function masRecientes()
    {
        $query = "SELECT c FROM Curso\CursoBundle\Entity\Curso c ORDER BY c.fechai ASC ";
        return $this->getEntityManager()->createQuery($query)->getResult();
    }
//    public function conPonenciaEs()
//    {
//        $query = "SELECT p FROM Desymfony\DesymfonyBundle\Entity\Ponencia p JOIN p.ponencias o WHERE o.idioma='es'";
//        return $this->getEntityManager()->createQuery($query)->getResult();
//    }

} 