<?php
namespace app\database;

use PDO;

class Conexion 
{
    /** Propiedades */
    private $Conection = null; public $Pps = null;
    public string $Query = ""; private array $ConfigDataBase;

    public function __construct()
    {
        $this->ConfigDataBase = require 'config/database.php';
    }
    /** Crear un método que realiza la conexión a la base de datos */

    public function getConexion()
    {
        try {
        $this->Conection = new PDO($this->ConfigDataBase["DRIVER_URL"],
        $this->ConfigDataBase["USERNAME"],$this->ConfigDataBase["PASSWORD"]);

        $this->Conection->exec("set names utf8");
        } catch (\Throwable $th) {
           echo $th->getMessage();
        }

        return $this->Conection;
    }

    /**
     * Liberamos recurso de la base de datos
     */
    public function closeDataBase()
    {
       if($this->Conection != null)
       {
        $this->Conection = null;
       } 

       if($this->Pps != null)
       {
        $this->Pps = null;
       }
    }
}