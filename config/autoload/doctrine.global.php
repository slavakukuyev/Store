<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

//config/autoload/doctrine.global.php
return array(
    'doctrine' => array(
        'connection' => array(
            'orm_default' => array(
                'driverClass' => 'Doctrine\DBAL\Driver\PDOMySql\Driver',
                    'params' => array(
                        'host' => 'localhost',                       
                        'dbname' => 'store',
                         'user' => 'store_user',
                        'password' => '4ebESHduqvqyvNL7',
                ),
            ),
        )
));
?>
