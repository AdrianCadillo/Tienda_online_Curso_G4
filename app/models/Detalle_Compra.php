<?php
namespace app\models;

use app\orm\Model;

class Detalle_Compra extends Model
{
     //protected string $Tabla = "producto";

     protected string $PrimaryKey = "id_detalle";

      /** Alias de la tabla */

     protected string $Alias = "dc";
}