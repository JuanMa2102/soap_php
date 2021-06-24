<?php

use isw\Service\CalculatorService;
use Laminas\Soap\AutoDiscover;
use Laminas\Soap\Server;

include __DIR__ . '/../../vendor/autoload.php';
$dbAdapter = include __DIR__ . '/../../config/auth.php';

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    if (! isset($_GET['wsdl'])) {
        header('HTTP/1.1 400 Client Error');
        return;
    }

    $autodiscover = new AutoDiscover();
    $autodiscover->setClass(CalculatorService::class)
        ->setUri('http://192.168.1.104:8000/calculator')
        ->setServiceName('CalculatorService');
    
    //$wsdl = $autodiscover->generate();
    header('Content-Type: application/wsdl+xml');
    echo $autodiscover->toXML();

    return;
}

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('HTTP/1.1 400 Client Error');
    return;
}

// pointing to the current file here
$soap = new Laminas\Soap\Server("http://192.168.1.104:8000/calculator?wsdl");

$soap->setClass(new CalculatorService($authAdapter));
$soap->handle();