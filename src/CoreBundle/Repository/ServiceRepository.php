<?php

namespace CoreBundle\Repository;


use CoreBundle\Entity\Service;

/**
 * ServiceRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ServiceRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new Service;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new Service : $obj;
        }
    }
}
