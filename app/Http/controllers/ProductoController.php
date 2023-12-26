<?php

class ProductoController 
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
}