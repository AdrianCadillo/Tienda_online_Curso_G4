<?php
namespace app\lib;

trait Request 
{

/** Método post */ 
public function post(string $input)
{
    if(isset($_POST[$input]))
    {
        return $_POST[$input];
    }

    return null;
}
/** Método get */ 
public function get(string $input)
{
    if(isset($_GET[$input]))
    {
        return $_GET[$input];
    }

    return null;
} 

/** Método REQUEST */ 
public function request(string $input)
{
    if(isset($_REQUEST[$input]))
    {
        return $_REQUEST[$input];
    }

    return null;
}

/** Método para validar si tenemos un archivo seleccionado */ 
public function file_size(string $input)
{
    return $_FILES[$input]['size'];
}
/** Método para validar obtener el tipo de archvo */ 
public function file_type(string $input)
{
    return $_FILES[$input]['type'];
}

/** Método para obtener el nombre del archivo */ 
public function file_Name(string $input)
{
    return $_FILES[$input]['name'];
}
/** Método para obtener el contenido del archivo */ 
public function fileContent(string $input)
{
    return $_FILES[$input]['tmp_name'];
}
}