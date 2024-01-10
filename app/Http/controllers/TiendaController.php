<?php

use app\lib\BaseController;
use app\models\Producto;

class TiendaController extends BaseController
{

/** Método para mostrar la vista de la tienda */
public function index()
{
    $model = new Producto;
    $Productos = $model->initQuery()->Where("deleted_at","is",null)->get();
    return View("tienda",compact("Productos"));
}

}