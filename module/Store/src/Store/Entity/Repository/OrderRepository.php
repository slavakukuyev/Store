<?php

namespace Store\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class OrderRepository extends EntityRepository {

    public function getRolesArray($number = 30) {
        return array();
    }

}

?>
