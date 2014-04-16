<?php

namespace Store\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class ProductRepository extends EntityRepository {

    public function getRolesArray($number = 30) {
        return array();
    }

}

?>
