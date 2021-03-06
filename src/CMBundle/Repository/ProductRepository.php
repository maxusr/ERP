<?php

namespace CMBundle\Repository;

/**
 * ProductRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ProductRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new \CMBundle\Entity\Product;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new \CMBundle\Entity\Product : $obj;
        }
    }
}
