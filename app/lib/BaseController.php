<?php
namespace app\lib;

class BaseController 
{
  public function __construct()
  {
      if(session_status() != PHP_SESSION_ACTIVE)
      {
        session_start();
      }
  }  
  use Request,Session,Csrf,Fecha,Authenticate;

  /** Método que muestra la cantidad de productos añadidos al carrito */

  public function CantidadProductosEnCarrito():int
  {
    return $this->ExistSession("carrito")? count($this->getSession("carrito")) : 0;
  }
}