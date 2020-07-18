<?php

require_once "config.php";

class Base{

    public function conectarBanco(){
        $pdo = null;
        try {
             //Conexao com banco de dados!
            $pdo = new PDO('pgsql:host='.HOSTNAME.';port='.PORTA.';dbname='.DBNAME, USERNAME, PASSWORD); 
            $pdo ->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
            
        }
        catch(PDOException $e ){ 
            $baseDesconectado = 'SQLSTATE[08006] [7] could not translate host name "'.HOSTNAME.'" to address: Name or service not known';
            if($e->getMessage() == $baseDesconectado){
                echo "<script>alert('Serviço fora do ar, verifica a sua internet ou a conexão com banco de dados!')</script>";
            }     

            die();
        }

    }

}

?>