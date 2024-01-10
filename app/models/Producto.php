<?php
namespace app\models;

use app\orm\Model;

class Producto extends Model
{
     //protected string $Tabla = "producto";

     protected string $PrimaryKey = "id_producto";

      /** Alias de la tabla */

     protected string $Alias = "pr";
}