<?php
namespace app\models;

use app\orm\Model;

class Compra extends Model
{
     //protected string $Tabla = "producto";

     protected string $PrimaryKey = "id_compra";

      /** Alias de la tabla */

     protected string $Alias = "c";
}