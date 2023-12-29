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

/** Método post */ 
public function file_size(string $input)
{
    return $_FILES[$input]['size'];
}
}