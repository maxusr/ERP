<?php

namespace SchoolBundle\Repository;

/**
 * ClassroomRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ClassroomRepository extends \Doctrine\ORM\EntityRepository
{
    public function oneOrNew($id = null) {
        if($id == null) {
            return new \SchoolBundle\Entity\Classroom;
        }else{
            $obj = $this->findOneById($id);
            return empty($obj) ? new \SchoolBundle\Entity\Classroom : $obj;
        }
    }
}
