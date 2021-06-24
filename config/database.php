<?php

use Laminas\Db\Adapter\Adapter as DbAdapter;

include __DIR__ . '/../vendor/autoload.php';

$adapter = new DbAdapter([
    'driver' => 'Pdo_Mysql',
    'database' => 'soap_php',
    'username' => 'soap_php',
    'password' => 'password',
]);

return $adapter;