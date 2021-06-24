<?php

use isw\Service\ProductsService;
use Laminas\Soap\AutoDiscover;

include __DIR__ . '/../vendor/autoload.php';
$dbAdapter = include '../config/database.php';
$authAdapter = include '../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (! isset($_GET['wsdl'])) {
        header('HTTP/1.1 400 Client Error');
        return;
    }

    $autodiscover = new AutoDiscover();
    $autodiscover
        ->setClass(ProductsService::class)
        ->setUri('http://192.168.1.104:8000/product.php')
        ->setServiceName('ProductsService');

        header('Content-Type: application/wsdl+xml');
        echo $autodiscover->toXml();
        return;

}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 400 Client Error');
    return;
}

// pointing to the current file here
$soap = new Laminas\Soap\Server("http://192.168.1.104:8000/product.php?wsdl");
$soap->setClass(new ProductsService($dbAdapter, $authAdapter));
$soap->handle();