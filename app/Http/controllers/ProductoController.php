<?php
 
use app\lib\BaseController;
use app\models\Producto;

class ProductoController extends BaseController
{
     
    public function index()
    {
        $modelProducto = new Producto;
        
        // echo "<pre>";
        // print_r($modelProducto->initQuery()
        // ->select("nombre_producto","precio","id_producto")
        // ->Where("precio",">",20) // V
        // ->Where("precio","=",890) /// F => F
        // ->WhereOr("id_producto","=",100) // V
        // ->get());
        // echo "</pre>";

        return $modelProducto->Update([
            "id_producto"=>7,
            "nombre_producto" =>"Goseosa Fanta de 3 litros",
            "precio" =>11.70,
            "descripcion" =>"descripcion de gaseosa fanta"
        ]);
        return;
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
        else
        {
            return "invalid";
        }
 
    }
}