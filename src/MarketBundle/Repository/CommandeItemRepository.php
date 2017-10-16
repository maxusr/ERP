<?php

namespace MarketBundle\Repository;

/**
 * CommandeItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CommandeItemRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new \MarketBundle\Entity\CommandeItem;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new \MarketBundle\Entity\CommandeItem : $obj;
        }
    }
}
