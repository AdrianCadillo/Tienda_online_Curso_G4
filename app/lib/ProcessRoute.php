<?php
namespace app\lib;
trait ProcessRoute
{
 
 private string $DirectorioController = "app/Http/controllers/";    

/** Obtener la ruta que escribimos en el navegador */
private function getRoute():array
{
    if(isset($_GET['ruta']))
    {
        return explode("/",$_GET['ruta']);
    }
}

/** Devolver al controlador */

private function getController():string /// DocenteController //docente/editar
{
 return !empty($this->getRoute()[0]) ? ucwords($this->getRoute()[0]):'';
}

/** Devolver al método */

private function getMethod():string /// DocenteController //docente/editar
{
 return !empty($this->getRoute()[1]) ?  $this->getRoute()[1]:'';
}

/** Proceso para en enrutador => ejecutar el enrutador */
public function run()
{
 if(!empty($this->getController()))
 {
  /// obtener en una variable al controlador
  $Controlador = $this->getController()."Controller";

  /// creamos una variable para indicarle la ruta del controlador

  $this->DirectorioController.=$Controlador.".php";

  /// verificar la existencia del controlador
  if(file_exists($this->DirectorioController))
  {
    # requirir el archivo controller

    require $this->DirectorioController;

    /// creamos un objeto que instancie al controlador
    $ObjetoController = new $Controlador;

    /// verificar si especificamos el método en la ruta
    if(!empty($this->getMethod()))
    {
     $Methodo = $this->getMethod();
/// verificar si el método existe dentro de un objeto
    if(method_exists($ObjetoController,$Methodo))
    {
         $this->getParams($ObjetoController,$Methodo);
    }
    }
    else
    {
        echo $ObjetoController->index();
    }    
  }
  else{
    echo "error 404-página no existe";
  }
 }
 else{
    echo "Pagína principal";
 }
}

/** Proceso para métodos con parámetros */
private function getParams($Objeto,$Methodo_)
{
    $CantidadRoute = sizeof($this->getRoute());

    if($CantidadRoute > 2) //[0]
    {
        /// contiene parametros
        $Parametros =[];

        for($i=2;$i< $CantidadRoute;$i++)
        {
           $Parametros []= $this->getRoute()[$i];
        }
 
        echo call_user_func_array([$Objeto,$Methodo_],$Parametros);
    }
    else
    {
        /// no contiene parametros

        echo $Objeto->{$Methodo_}();
    }
}
}