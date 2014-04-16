<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

namespace AuthDoctrine\Entity\Repository;

use Doctrine\ORM\EntityRepository;

class UserRepository extends EntityRepository {

    public function getRolesArray($number = 30) {
        return array();
    }

}

?>
