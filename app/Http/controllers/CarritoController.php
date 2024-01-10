<?php

use app\lib\BaseController;
use app\models\Producto;

class CarritoController extends BaseController
{


/** Método para mostrar la vista del carrito */
public function index()
{
    return View("carrito");
}    
/** Añadir producto al carrito de compras */
public function addCart()
{
 /// validamos el token
 if($this->VerifyTokenCsrf($this->post("_token")))
 {
   $model = new Producto;
  /// obtenemos el id
  $Producto_Id = $this->post("producto_id");
  /// consultamos los producto
  $Producto = $model->initQuery()->Where("id_producto","=",$Producto_Id)->get();

  $this->ProcessAddCarrito(
   $Producto[0]->nombre_producto,
   $Producto[0]->precio,
   1,
   $Producto[0]->foto
  );
 
 }
 else
 {
    $this->Sesion("error","El token es incorrecto");
 }
 Back();
}

/** Método para proceso de añadir al carrito */
private function ProcessAddCarrito(string $producto,float $precio,int $cantidad,string $foto)
{
  /// verificar si existe la variable carrito
  if(!$this->ExistSession("carrito"))
  {
    /// lo creamos
    $this->Sesion("carrito",[]);
  }

  /// si la key del carrito existe
  /**
   * ["carrito"]["nombre_producto"]["precio"]
   * ["carrito"]["nombre_producto"]["cantidad"]
   */

   if(!array_key_exists($producto,$_SESSION['carrito'])){
    /// seguimos agregando al carrito de compras
    $_SESSION["carrito"][$producto]["precio"] = $precio;
    $_SESSION["carrito"][$producto]["cantidad"] = $cantidad;
    $_SESSION["carrito"][$producto]["foto"] = $foto;
   }
   else
   {
    // se le modifica la cantidad del producto
    $_SESSION["carrito"][$producto]["cantidad"]+= 1;

   }
}

/** Método para quitar de la cesta */
public function quitar_de_la_cesta()
{
   
  /// validamos el token
 if($this->VerifyTokenCsrf($this->post("_token")))
 {
    /// obtener el producto seleccionado
    $ProductoDelete = $this->post("producto_delete");
    if(isset($_SESSION["carrito"][$ProductoDelete]))
    {
        /// lo eliminamos de la lista
        unset($_SESSION['carrito'][$ProductoDelete]);
         
    }
    else
    {
        return "error";
    }
 } 
 Back();
 
}
}