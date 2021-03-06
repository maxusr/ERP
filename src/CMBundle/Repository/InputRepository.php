<?php

namespace CMBundle\Repository;

/**
 * EntryRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class InputRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new \CMBundle\Entity\Input;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new \CMBundle\Entity\Input : $obj;
        }
    }
}
