<?php

use Windwalker\Edge\Edge;
use Windwalker\Edge\Loader\EdgeFileLoader;

/**Variable que obtiene la configuración */
$AppConfig = require 'config/app.php';
/** Método para obtener las variables de entorno */

function env(string $NameVariable,string $DefectValue="")
{
    if(isset($_ENV[$NameVariable]))
    {
       return $_ENV[$NameVariable]; 
    }

    return  $DefectValue;
}

/** Mostrar las vistas */
function View(string $vista,array $data =[])
{
    $DirectorioView = "resources.views.";

    $DirectorioView = str_replace(".","/",$DirectorioView.$vista).".blade.php";
    

    if(file_exists($DirectorioView))
    {
        $Blade = new Edge(new EdgeFileLoader());

        return $Blade->render($DirectorioView,$data);
    }
    else{
        return "error ";
    }
}

/** Método asset */

function asset(string $directorio):String
{
    return $GLOBALS["AppConfig"]["BASE_URL"].$GLOBALS["AppConfig"]["DIRECTORIO_ASSET"].$directorio;
}

/** component */

function component(string $componente):string
{
    return  str_replace(".","/",$GLOBALS["AppConfig"]["DIRECTORIO_COMPONENTE"].$componente).".blade.php";
}

/** Método que apunte a la plantilla => layout */
function layout(string $layout)
{
    return  str_replace(".","/",$GLOBALS["AppConfig"]["DIRECTORIO_LAYOUT"].$layout).".blade.php";
}

/** Método para apuntar a una ruta */
function route(string $ruta)
{
    return $GLOBALS["AppConfig"]["BASE_URL"].$ruta;
}

 
 