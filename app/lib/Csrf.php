<?php
namespace app\lib;

trait Csrf 
{

  private string $NameToken = "token";

  use Session,Request;
  
  /** Método para obtener el token Csrf*/

  public function Csrf()
  {
    /// generamos el token
    $Token = bin2hex(random_bytes(32));

    /// verificar si ya existe un token
    if(!$this->ExistSession($this->NameToken))
    {
        $this->Sesion($this->NameToken,$Token);
    }

    return $this->getSession($this->NameToken);
  }

  /** Método para obtener el token Csrf en un input*/

  public function InputCsrf()
  {
    /// generamos el token
    $Token = bin2hex(random_bytes(32));

    /// verificar si ya existe un token
    if(!$this->ExistSession($this->NameToken))
    {
        $this->Sesion($this->NameToken,$Token);
    }

    return "<input name='_token' value=".$this->getSession($this->NameToken).">";
  }

  /** Validar la existencia del token y verificarlo si una petición hace uso de ello*/

  public function VerifyTokenCsrf(string|null $tokenInput):bool
  {
    if(isset($tokenInput))
    {
        if($this->ExistSession($this->NameToken) and $this->getSession($this->NameToken) === $tokenInput)
        {
          return true;
        }
    
        return false;
    }
    return false;
  }

}