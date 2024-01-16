<?php
namespace app\models;

use app\orm\Model;

class Usuario extends Model
{
     //protected string $Tabla = "producto";

     protected string $PrimaryKey = "id_usuario";

      /** Alias de la tabla */

     protected string $Alias = "usu";
}