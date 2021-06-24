<?php 

use Laminas\Crypt\Password\Bcrypt;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;

include __DIR__ . '/../vendor/autoload.php';

$dbAdapter = include 'database.php';
// Configure the instance with constructor parameters:
$authAdapter = new AuthAdapter(
    $dbAdapter,
    'users',
    'soap_php',
    'password'
);

$authAdapter->setIdentityColumn('username');
$authAdapter->setCredentialColumn('password');

$authAdapter->setCredentialValidationCallback(function($hash, $password){
     $bycript = new Bcrypt();
     return $bycript->verify($password, $hash);
}); 



return $authAdapter;