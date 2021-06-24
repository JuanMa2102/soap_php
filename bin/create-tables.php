<?php

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Db\Adapter\Driver\Pdo\Pdo;

include __DIR__ . '/../vendor/autoload.php';

$adapter = new DbAdapter([
    'driver' => 'Pdo_Mysql',
    'database' => 'soap_php',
    'username' => 'soap_php',
    'password' => 'password',
]);

$sqlCreate = 'CREATE TABLE users ('
    . 'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, '
    . 'username VARCHAR(50) UNIQUE NOT NULL, '
    . 'password VARCHAR(100) NULL, '
    . 'real_name VARCHAR(150) NULL)';

$result = $adapter->query($sqlCreate);
$result->execute();

$bcript = new Bcrypt();

// Build a query to insert a row for which authentication may succeed
$sqlInsert = "INSERT INTO users (username, `password` , real_name) "
        . "VALUES ('cliente1','" . $bcript->create('admin') . "', 'My Real Name')";
    
// Insert the data
$stmt = $adapter->query($sqlInsert);
$stmt->execute();

$productCreate = 'CREATE TABLE products ('
    . 'id INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY, '
    . 'name VARCHAR(50) UNIQUE NOT NULL, '
    . 'description VARCHAR(100) NULL )';

$result2 = $adapter->query($productCreate);
$result2->execute();
