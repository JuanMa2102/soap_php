<?php

namespace isw\Service;

use Laminas\Db\Adapter\Adapter as DbAdapter;
use Laminas\Authentication\Adapter\DbTable\CallbackCheckAdapter as AuthAdapter;

class ProductsService
{
    /**
     * @var DbAdapter
     * @var AuthAdapter
     */
    public function __construct(DbAdapter $dbAdapter, AuthAdapter $auth)
    {
        $this->dbAdapter = $dbAdapter;    
        $this->auth = $auth;  
    }

     /**
     * Agregar un nuevo producto
     * @param string $name
     * @param string $description
     * @param string $username
     * @param string $password
     * @return string 
     */
    public function create(string $name, string $description, string $username, string $password){

        if(!$this->authenticate($username,$password))
        {
            return ("La autenticacion ha fallado");
        }
        else{
            $sqlInsert = "INSERT INTO products (name,description) "
            . "VALUES ('$name','$description')";

            $stmt = $this->dbAdapter->query($sqlInsert);
            $stmt->execute();

            return 'Se agrego correctamente el producto ' . $name ;
        }
    }

    /**
     * Actualizar un producto
     * @param int $id
     * @param string $name
     * @param string $description
     * @param string $username
     * @param string $password
     * @return string 
     */
    public function update(int $id, string $name, string $description, string $username, string $password){
        
        if(!$this->authenticate($username,$password))
        {
            return ("La autenticacion ha fallado");
        }
        else{
            $sqlUpdate = "UPDATE products 
                SET name = '$name', 
                    description = '$description' 
                WHERE id = '$id'";
            
            $stmt = $this->dbAdapter->query($sqlUpdate);
            $stmt->execute();

            return 'Se actualizo correctamente el producto ';
        }
    }

    /**
     * Eliminar un producto
     * @param int $id
     * @param string $username
     * @param string $password
     * @return string 
     */
    public function delete(int $id, string $username, string $password){

        if(!$this->authenticate($username,$password))
        {
            return ("La autenticacion ha fallado");
        }
        else{
            $sqlDelete = "DELETE FROM products 
                WHERE id= '$id' ";

            $stmt = $this->dbAdapter->query($sqlDelete);
            $stmt->execute();

            return 'Se elimino correctamente el producto ';
        }
    }


    //authenticacion 
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