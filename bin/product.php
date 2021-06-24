<?php

use Laminas\Soap\Client;

include __DIR__ . '/../vendor/autoload.php';

    $product = new Client('http://192.168.1.104:8000/product.php?wsdl');

    var_dump($product->getFunctions());
    
    //autenticacion
    $username = 'cliente1';
    $password = 'admin';

    //productos
    $id = 1;
    $name = 'Shampoo';
    $description = 'Shampoo anti-caida';

    // Agregar un nuevo producto
    $result1 = $product->create($name, $description, $username, $password);
    echo "Message:  {$result1} \n";

    //Actualizar un producto
    $name = 'Shampoo Nuevo';

    $result1 = $product->update($id, $name, $description, $username, $password);
    echo "Message:  {$result1} \n";

    //Eliminar un producto
    $result1 = $product->delete($id, $username, $password);
    echo "Message:  {$result1} \n";
