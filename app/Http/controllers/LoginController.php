<?php

use app\lib\BaseController;

class LoginController extends BaseController
{

  private array $ErrorLogin =[];  
 /** Método para visualizar el formulario de login */
 public function index()
 {
    return View("login_view");
 }

 /** Método para acceder al sistema */
 public function login_acceso()
 {
   /// validamos el token
   if($this->VerifyTokenCsrf($this->post("_token")))
   {
      /// validamos los input del login
      if(empty($this->post("username")))
      {
         $this->ErrorLogin [] = 'Ingrese su nombre de usuario | email ....';
      }

      if(empty($this->post("password")))
      {
         $this->ErrorLogin [] = 'Ingrese su password ....';  
      }

      if(count($this->ErrorLogin) > 0)
      {
        $this->Sesion("login_errors",$this->ErrorLogin); 
      }
      else
      {
         $this->Attemp([
          "username" => $this->post("username"),
          "password" => $this->post("password")
         ]);
         exit;
      }
   }
   else
   {
      $this->Sesion( "error_login","Error, Token invalidate");
   }
   Back();
 }
}