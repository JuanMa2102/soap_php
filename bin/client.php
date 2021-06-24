<?php

use Laminas\Soap\Client;

include __DIR__ . '/../vendor/autoload.php';

$client = new Client('http://192.168.1.104:8000/calculator?wsdl');
//var_dump($client->getFunctions());
$username = 'cliente1';
$password = 'admin';
//$2y$10$cSwHPJcWGZKBJ/JvcJFc1On86b2Z9Xx1vybi0.9Ui1LYpsG7zpm06

$result1 = $client->add($username, $password, 20, 10);
echo "Suma:  {$result1} \n";

$result2 = $client->multiply(22,100);
echo "Multiply: {$result2} \n";
