<?php

use app\lib\{BaseController,Email};
use app\models\Usuario;
class ClienteController extends BaseController
{
 use Email;
 /** Validamos los inputs */
  private array $Errors = [];
 /** Método para crear la cuenta del cliente */
 public function create_account()
 {
    return View("cliente.create-account");
 }

 /** Crear la cuenta del cliente */
 public function saveAccount()
 {
       
        /**Validamos el token */
        if ($this->VerifyTokenCsrf($this->post("_token"))) {
            /// validamos el campo username
            empty($this->post("username")) ? $this->Errors[] = 'Complete el campo username..' : '';
            /// validamos el email
            if (empty($this->post("email"))) {
                $this->Errors[] = 'Complete su email...';
            } else {
                if (!filter_var($this->post("email"), FILTER_VALIDATE_EMAIL)) {
                    $this->Errors[] = 'Correo electrónico incorrecto..';
                }
            }

            /// validamos el password
            empty($this->post("password")) ? $this->Errors[] = 'Complete su password..' : '';

            if (empty($this->post("confirm_password"))) {
                $this->Errors[] = 'Confirme su password...';
            } else {
                if ($this->post("password") !== $this->post("confirm_password")) {
                    $this->Errors[] = 'Error, los passwords no coinciden';
                }
            }

            if (count($this->Errors) > 0) {
                $this->Sesion("errors", $this->Errors);
                Back();
            } else {
                /// continuamos proceso
                return $this->procesoSaveCliente();
            }
        }
    }

    /// registrar la cuenta del cliente
    private function procesoSaveCliente()
    {
        $model = new Usuario;

        $model->nombre_user = $this->post("username");
        $model->email = $this->post("email");
        $model->password_ = password_hash($this->post("password"),PASSWORD_BCRYPT);
        $model->token_validate = bin2hex(random_bytes(64));
        $model->codigo_confirm = GeneraCodeAleatorio();

        $model->tiempo_expired = time() +60*15; /// 2 minutos de vida

        if($model->save())
        {
            $ConsultamosCliente = $model->initQuery()
            ->Where("nombre_user","=",$this->post("username"))->get();
            /// enviamos el correo con el código de confirmación al correo del cliente

            $ResponseSend = $this->send([
                "email" => $ConsultamosCliente[0]->email,"name" => $ConsultamosCliente[0]->nombre_user,
                "asunto" => "Confirmar su cuenta!","body" => "<h3>CÓDIGO : ".$ConsultamosCliente[0]->codigo_confirm."</h3>"
            ]);

            if($ResponseSend)
            {
                /// redirigir a la vista de confirmar la cuenta mediante código
                Redirect("cliente/confirmar_cuenta?id=".$ConsultamosCliente[0]->id_usuario."&&token=".$ConsultamosCliente[0]->token_validate);
            }
            else{
             $model->delete($ConsultamosCliente[0]->id_usuario);
             $this->Sesion("error_mail","Error al enviar correo electrónico para confirma la cuenta");
             Back();
             exit;
            }
        }
    }

    public function confirmar_cuenta()
    {
      /// validamos si las variables por get existen
      if($this->get("id")!= null and $this->get("token") != null)
      {
       $modelCliente = new Usuario;
       $ClienteExiste = $modelCliente->initQuery()
       ->Where("id_usuario","=",$this->get("id"))
       ->Where("token_validate","=",$this->get("token"))->get();
       
       if($ClienteExiste)
       {
          /// verificamos el tiempo de expiración 
          if($ClienteExiste[0]->tiempo_expired > time())
          {
            return View("cliente.confirmar_cuenta");
            exit;
          }
          else{
           $this->Sesion("error_confirm","Error,el tiempo de expiración a vencido.");
           $modelCliente->delete($ClienteExiste[0]->id_usuario);
          }
       }
       else{
        $this->Sesion("error_confirm","Error, no se puede mostrar la vista de confirmar la cuenta.");
       }
      }
      else
      {
        $this->Sesion("error_confirm","Error,no se puede mostrar la vista de confirmar la cuenta.");
      }
      Back();
    }

  /** Proceso para activar la cuenta */
  public function confirm_cuenta()
  {
   /// validamos el token csrf
   if($this->VerifyTokenCsrf($this->post("_token")))
   {
    $modelUser = new Usuario;
    
    $response = $modelUser->initQuery()
    ->Where("codigo_confirm","=",$this->post("codigo"))->get();
    if($response)
    {
        $modelUser->Update([
            "id_usuario" => $response[0]->id_usuario,
            "token_validate" => null,
            "codigo_confirm" => null,
            "tiempo_expired" => null
        ]);
        /// creamos una variable de sessión, para acceder al sistema
        $this->Sesion("user",$response[0]->id_usuario);
        Redirect("tienda");
        exit;
    }else{
        /// creamos una variable de session para mostrar el error
        $this->Sesion("error_","El código es incorrecto");
    }
   }
   else
   {
    $this->Sesion("error_","Token incorrecto!");
   }
   Back();
  }

  /** Método para cerrar la sesión */
  public function logout()
  {
    if($this->VerifyTokenCsrf($this->post("_token")))
    {
        $this->_logout();
    }
  }
}