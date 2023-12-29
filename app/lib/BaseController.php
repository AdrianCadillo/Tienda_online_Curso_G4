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
  use Request,Session,Csrf;
}