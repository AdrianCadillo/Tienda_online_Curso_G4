<?php
namespace app\lib;

trait Session
{

/** Método para asignar un valor a una sesión */
public function Sesion(string $NameSession,string|int|float|bool|array $value):void
{
   $_SESSION[$NameSession] = $value; 
}  

/**
 * Método para verificar la existencia de una variable de sesión
 */
public function ExistSession(string $NameSession):bool
{
 return isset($_SESSION[$NameSession]);
}

/**
 * Método que accede a una variable de sesión
 */
public function getSession(string $NameSession):string|int|bool|array
{
   return $_SESSION[$NameSession];
}

/**Eliminar una variable de sesión */
public function destroyOneSesion(string $NameSession):void
{
   unset($_SESSION[$NameSession]); 
}

/**
 * Destruir toda variable de sesión
 */
public function DestroyAllSesion(string $NameSession):void
{
  if($this->ExistSession($NameSession))
  {
    session_destroy();
  }
}
}