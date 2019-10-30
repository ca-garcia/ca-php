<?php

namespace Desymfony\DesymfonyBundle\Entity;
use Doctrine\ORM\EntityRepository;


class PonenteRepository extends EntityRepository
{
    public function encontrarTodosAlfabeticamente()
    {
        $query = 'SELECT p FROM Desymfony\DesymfonyBundle\Entity\Ponente p ORDER BY p.nombre ASC';
        return $this->getEntityManager()->createQuery($query)->getResult();
    }

    public function conPonenciaEs()
    {
        $query = "SELECT p FROM Desymfony\DesymfonyBundle\Entity\Ponente p JOIN p.ponencias o WHERE o.idioma='es'";
        return $this->getEntityManager()->createQuery($query)->getResult();
    }


}


