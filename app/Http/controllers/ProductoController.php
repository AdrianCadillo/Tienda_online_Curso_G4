<?php

use app\database\Conexion;
use app\lib\BaseController;

class ProductoController extends BaseController
{
     
    public function index()
    {
         
        return View("producto.index");
    }

    public function create()
    {
        return "mostramos el formulario de crear productos";
    }

    public function editar($id,$estudiante)
    {
        return $id."   ".$estudiante;
    }

    public function save()
    {
        if($this->VerifyTokenCsrf($this->post("_token")))
        {
            return "pasaste el token";
        } 
         
            return "invalid";
         
 
    }
}