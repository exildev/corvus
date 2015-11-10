<?php

define('host', '127.0.0.1');
define('port', '5432');
define('user', 'postgres');
define('pass', '123456');

$install = array(
    'pack1' => array(
        'controller'=>'ContrPack1',
        'model' =>array(
            'Persona',
            'Perro',
            'Casa'
         )
    )
);


?>
