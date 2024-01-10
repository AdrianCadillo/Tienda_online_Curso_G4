<?php
namespace app\orm;

use app\database\Conexion;

class Model extends Conexion implements orm
{
   use Save;
   protected string $Tabla = "";

   /** Indicamos la clave primaria */
   protected string $PrimaryKey;

   /** Alias de la tabla */

   protected string $Alias;

    

   /// para los valores que enviamos al hacer where 

   private array $Values = []; /// 0
   /** Método para inicializar la query => select *from tabla */
   public function initQuery()
   {
     $this->ValidateTablaClass(); 
     $this->Query = "SELECT * FROM ".$this->Tabla." as ".$this->Alias;

     return $this;
   } 

    /** Método para mostrar atributos de una tabla es específico */

    public function select() //("nombre","precio","descripcion")
    {
       $AtributosView = func_get_args();  //// ["nombre","precio","descripcuion"]

       $AtributosView = implode(",",$AtributosView);

       $this->Query = str_replace("*",$AtributosView,$this->Query);
       
       return $this;

    }

    /** MÉTODO WHERE PARA MOSRAR REGISTROS DE ACUERDO A UNA CONDICION */
    public function Where(string $atributo,string $operador,string|int|null|bool|float $value)
    {
        if(count($this->Values) > 0) /// and
        {
            $this->Query.=" AND $atributo $operador ?";
        }
        else
        {
            $this->Query.=" WHERE $atributo $operador ?";
        }


        $this->Values [] = $value;

        return $this;
    }

     /** Método para realizar en or */
     public function WhereOr(string $atributo,string $operador,string|int|null|bool|float $value)
     {
        $this->Query.=" OR $atributo $operador ?";  

        $this->Values [] = $value;

        return $this;
     }

   
    /** Método que ejecuta las consultas */
    public function get()
    {
       
      try {
        $this->Pps = $this->getConexion()->prepare($this->Query);

        if(count($this->Values) > 0)
        {
          for($iteracion = 0;$iteracion<count($this->Values);$iteracion++)
          {
            $this->Pps->bindParam($iteracion+1,$this->Values[$iteracion]);
          }
        }
        
        $this->Pps->execute();


        return $this->Pps->fetchAll(\PDO::FETCH_OBJ);
      } catch (\Throwable $th) {
        echo "<h2>".$th->getMessage()."</h2>";
        exit;
      }finally{
        $this->closeDataBase();
      }
    }

  /*** insert
   * 
   * INSERT INTO TABLA(atributo1,atributo1,.....atributon) VALUES(:atributo1,:atributo2)
   * ["clave"=>valor]
   */
  public function Insert(array $datos)
  {
    $this->ValidateTablaClass();
    $this->Query = "INSERT INTO ".$this->Tabla."(";

    /** Recorremos los datos, para los atributos*/
    foreach($datos as $atributo => $value):
     $this->Query.=$atributo.",";
    endforeach;
    /// eliminamos la última ,
    $this->Query = rtrim($this->Query,",").") VALUES(";

    /** Recorremos los datos, para los valores */
    foreach($datos as $atributo => $value):
        $this->Query.=":".$atributo.",";
    endforeach;
    /// eliminamos la última ,
    $this->Query = rtrim($this->Query,",").")";

    return $this->ExecQuery($datos,$this->Query);

  }

  /*** save para realizar registros */
  public function save()
  {
    $this->ValidateTablaClass();
    $this->Query = "INSERT INTO ".$this->Tabla."(";

    /** Recorremos los datos, para los atributos*/
    foreach($this->getAtributes() as $atributo => $value):
     $this->Query.=$atributo.",";
    endforeach;
    /// eliminamos la última ,
    $this->Query = rtrim($this->Query,",").") VALUES(";

    /** Recorremos los datos, para los valores */
    foreach($this->getAtributes() as $atributo => $value):
        $this->Query.=":".$atributo.",";
    endforeach;
    /// eliminamos la última ,
    $this->Query = rtrim($this->Query,",").")";

    return $this->ExecQuery($this->getAtributes(),$this->Query);
  }
  /*** actualizar o modificar 
   update tabla set atributo1=valor1,atributo2=valor2
   where id_tabla = 12;

   UPDATE TABLA SET atributo1=:atributo1 WHERE id_producto=:id_producto
  */
  public function Update(array $datos)
  {
    $this->ValidateTablaClass();
    $this->Query = "UPDATE ".$this->Tabla." SET ";

    /** Recorremos los datos, para los atributos*/
    foreach($datos as $atributo => $value):
     $this->Query.= $atributo."=:".$atributo.",";
    endforeach;
    /// eliminamos la última ,
    $this->Query = rtrim($this->Query,",")." WHERE ".array_key_first($datos)."= :".array_key_first($datos);
  
    return $this->ExecQuery($datos,$this->Query);
  }

  /**ejecutar la query del insert, update */
  private function ExecQuery(array $datos,string $Sql):bool
  {
   try {
     $this->Pps = $this->getConexion()->prepare($Sql);
     foreach($datos as $atributo => $value):
     $this->Pps->bindValue(":$atributo",$value);
     endforeach;

     /// ejecutamos la query evento I u -d
     return $this->Pps->execute();
   } catch (\Throwable $th) {
    echo "<h2>".$th->getMessage()."</h2>";
    exit;
   }finally{
    $this->closeDataBase();
   }
  }

  private function ValidateTablaClass():void
  {
    if(empty($this->Tabla))
    {
     $this->Tabla = strtolower(explode("/",str_replace("\\","/",get_class($this)))[2]);
    }
  }

  /** Para eliminar registros
   *DELETE FROM TABLA WHERE id=4
   */
  public function delete(int $id)
  {
    $this->ValidateTablaClass();
    $this->Query = "DELETE FROM ".$this->Tabla." WHERE ".$this->PrimaryKey."=:".$this->PrimaryKey;
    try {
      $this->Pps = $this->getConexion()->prepare($this->Query);
      $this->Pps->bindParam(":".$this->PrimaryKey,$id);

      return $this->Pps->execute();
    } catch (\Throwable $th) {
      echo "<h2>".$th->getMessage()."</h2>";
    }finally{
      $this->closeDataBase();
    }
  }
}