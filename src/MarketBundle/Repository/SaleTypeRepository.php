<?php

namespace MarketBundle\Repository;

/**
 * SaleTypeRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class SaleTypeRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new \MarketBundle\Entity\SaleType;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new \MarketBundle\Entity\SaleType : $obj;
        }
    }
}
