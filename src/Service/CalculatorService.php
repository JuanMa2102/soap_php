<?php

namespace isw\Service;

use Exception;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;

class CalculatorService
{
    /**
     * @var AuthAdapter
     */
    public function __construct(AuthAdapter $auth)
    {
        $this->auth = $auth;    
    }
    /**
     * add two numbers
     * @param string $username
     * @param string $password
     * @param float $x
     * @param float $y
     * @return float 
     */
    public function add(string $username, string $password,float $x, float $y)
    {
        if(!$this->authenticate($username,$password))
        {
            return ("La autenticacion ha fallado");
        }
        else
        return $x + $y;
    }

    /**
     * sub two numbers
     * @param float $x
     * @param float $y
     * @return float 
     */
    public function sub (float $x, float $y)
    {
        return $x - $y;
    }

    /**
     * multiply two numbers
     * @param float $x
     * @param float $y
     * @return float 
     */
    public function multiply (float $x, float $y)
    {
        return $x * $y;
    }

    /**
     * divide two numbers
     * @param float $x
     * @param float $y
     * @return float 
     */
    public function div (float $x, float $y)
    {
        if($y == 0)
            $y = 1;

        return $x / $y;
    }

    private function authenticate(string $username, string $password)
    {
        $adapter = $this->auth;
        $adapter->setIdentity($username);
        $adapter->setCredential($password);

        try {
            $result = $adapter->authenticate();

            ob_start();
            var_dump($result->getMessages());
            $data = ob_get_clean();

            file_put_contents('/tmp/error.log', $data . "\n", FILE_APPEND);
            
            return $result->isValid();

        } catch (\Exception | \Error $e){
            file_put_contents('/tmp/error.log', $e->getMessage() . "\n", FILE_APPEND);
        }
    }
}