<?php

namespace CoreBundle\Repository;


use CoreBundle\Entity\Echelon;

/**
 * EchelonRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class EchelonRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new Echelon;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new Echelon : $obj;
        }
    }
}
