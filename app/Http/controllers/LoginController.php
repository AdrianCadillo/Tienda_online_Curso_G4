<?php

use app\lib\BaseController;
use app\lib\Email;
use app\models\Usuario;

class LoginController extends BaseController
{
  use Email;
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

 /** Método para mostrar la vista de reseteo de contraseña*/
 public function reseteo_password()
 {
   return View("reseteo_password");
 }

 /** Proceso para el reseteo de contraseña */
 public function proceso_reseteo()
 {
   /// validar el token
   if($this->VerifyTokenCsrf($this->post("_token")))
   {
      /// validar el email
      if(empty($this->post("email")))
      {
         $this->Sesion("error","Complete su email..");
      }
      else
      {
         if(!filter_var($this->post("email"),FILTER_VALIDATE_EMAIL))
         {
            $this->Sesion("error","El email que especificas es incorrecto");
         }
         else
         {
            /// verificamos si ese correo existe en la base de datos
            $userModel = new Usuario;

            $respuesta = $userModel->initQuery()
            ->Where("email","=",$this->post("email"))->get();

            if($respuesta)
            {
               /// comparar si lo que escribio es igual a lo que está en la bd
               if($respuesta[0]->email === $this->post("email"))
               {
                  /// enviamos el correo

                   $this->SendReseteoPasswordProceso(
                     $respuesta[0]->id_usuario,$respuesta[0]->email,
                     $respuesta[0]->nombre_user,"Cambiar la contraseña"
                   );
                   $this->Sesion("success","Le hemos enviado un correo con un enlace para que pueda resetear la contraseña");
                  
               }
               else
               {
                  $this->Sesion("error","El email especificado es incorrecto");
               }
            }
            else
            {
               $this->Sesion("error","El email especificado no existe en la base de datos");
            }
         }
      }
      Back();
   }
 }

 /** Proceso de envio del correo para el reseteo de contraseña */
 private function SendReseteoPasswordProceso(int $id_user,string $email,
 string $name,string $asunto)
 {
   /// actualizar la tabla usuario
   $modelUser = new Usuario;
   $modelUser->Update([
      "id_usuario" => $id_user,
      "request_password" => 1,
      "token_request_password" => bin2hex(random_bytes(32)),
      "tiempo_expired" => time()+120
   ]);

   $UserReseteoData = $modelUser->initQuery()->Where("id_usuario","=",$id_user)->get();

   /// enviar el correo
   $RespuestaCorreo = $this->send([
      "email" => $email,
      "name" => $name,
      "asunto" => $asunto,
      "body" => '<a href="'.env("BASE_URL").'login/cambiar_password?id='.$id_user.'&&token='.$UserReseteoData[0]->token_request_password.'">Click aquí para cambiar su contraseña</a>'
   ]);
 }

 /// visualizar la vista de cambiar la contraseña
 public function cambiar_password()
 {
   return View("cambiar_contrasenia");
 }

}