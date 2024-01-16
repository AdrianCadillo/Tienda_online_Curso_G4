<?php

namespace app\lib;

use app\models\Usuario;

trait Authenticate
{
    use Session;

    /** Capturar los datos del usuarios authenticado */
    public function DataUser()
    {
        /// validamos si existe la variable de sesion user
        if ($this->ExistSession("user")) {
            /// capturo los datos
            $modelUser = new Usuario;

            $Data = $modelUser->initQuery()
                ->Where("id_usuario", "=", $this->getSession("user"))->get();
        }

        return $Data;
    }

    /**
     * Cerrar la sesión
     */
    public function _logout()
    {
        if ($this->ExistSession("user")) {
            $this->destroyOneSesion("user");
            Redirect("tienda");
            exit;
        }
    }

    /** Proceso para la authenticación */
    public function Attemp(array $credenciales = [])
    {
        $modelUser = new Usuario;

        $UserData = $modelUser->initQuery()
            ->Where("email", "=", $credenciales["username"])
            ->WhereOr("nombre_user", "=", $credenciales["username"])
            ->get();
        /// verificar si existe ese usuario
        if ($UserData) {
            if (
                $credenciales["username"] === $UserData[0]->nombre_user or
                $credenciales["username"] === $UserData[0]->email
            ) {
                /// comprobar la contraseña
                $Password = $UserData[0]->password_;
                if (password_verify($credenciales["password"], $Password)) {
                    /// capturar si dió recordar la sesión
                    $this->Sesion("user", $UserData[0]->id_usuario);
                    /// verificar quién dio inicio sesión (Cliente | admin)
                    if ($this->DataUser()[0]->rol === 'cliente') {
                        Redirect("carrito");
                    } else {
                        Redirect("producto");
                    }
                    exit;
                } else {
                    $this->Sesion("error_login", "Password incorrecto");
                }
            } else {
                $this->Sesion("error_login", "Nombre de usuario incorrecto.");
            }
        } else {
            $this->Sesion("error_login", "Nombre de usuario incorrecto");
        }
        Back();
    }
}
