<?php

use app\lib\BaseController;
use app\lib\Upload;
use app\models\Producto;

class ProductoController extends BaseController
{
  use Upload;
  public function index()
  {
    $this->NoAutheticado();///tienda
    if($this->DataUser()[0]->rol === 'administrador')
    {
      return View("producto.index");
    }
    
    return View("page_errors.NoAutorizado");
  }

  /** Método para mostrar la vista de crear nuevos productos */
  public function create()
  {
    return View("producto.create");
  }

  /** Mostrar los productos en formato json */
  public function mostrarProductos()
  {
    /// verificar el token de seguridad

    if ($this->VerifyTokenCsrf($this->get("_token"))) {
      $Producto = new Producto;

      $DatosProductos = $Producto->initQuery()
        ->Where("deleted_at", $this->get("operador"), null)->get();

      echo json(['response' => $DatosProductos]);
    } else {
      return json([]);
    }
  }

  /** Método para registrar nuevos productos */
  public function store()
  {
    /// Validamos el token
    if ($this->VerifyTokenCsrf($this->post("_token"))) {
      /// proceso de guardado
      if ($this->UploadImage("foto") !== 'archivo-no-accept') {
        $modelProducto = new Producto;

        $ExisteProducto = $modelProducto->initQuery()
          ->Where("nombre_producto", "=", $this->post("nombre_producto"))->get();

        if (!$ExisteProducto) {
          $Respuesta = $modelProducto->Insert([
            "nombre_producto" => $this->post("nombre_producto"),
            "descripcion" => $this->post("descripcion"),
            "precio" => $this->post("precio"),
            "foto" => $this->getNOmbreImagen()
          ]);

          $this->Sesion("success", $Respuesta ? 'ok' : 'error');
        } else {
          $this->Sesion("warning", 'existe');
        }
      } else {
        $this->Sesion("error", "Error, el archivo seleccionado es incorrecto");
      }
    } else {
      $this->Sesion("error", "Error, Token Invalidate");
    }

    /// redireccionar
    Back();
  }

  /** Método para modificar los productos */
  public function modificar(int $id)
  {

    /// validamos el token
    if ($this->VerifyTokenCsrf($this->post("_token"))) {

      $model = new Producto;
      $Subida = $this->UploadImage("foto");

      $Producto = $model->initQuery()->Where("id_producto", "=", $id)->get();

      if ($Subida !== 'vacio') {
        if ($Subida !== 'archivo-no-accept') {
          /// eliminar la imágen anterior
          $Producto[0]->foto != null ? unlink("{{asset('dist/foto/')}}" . $Producto[0]->foto) : '';
          $Foto = $this->getNOmbreImagen();
        } else {
          return json(["response" => "archivo-incorrecto"]);
        }
      } else {
        $Foto = $Producto[0]->foto;
      }

      /// modificar los productos

      $Respuesta = $model->Update([
        "id_producto" => $id,
        "nombre_producto" => $this->post("nombre_producto"),
        "precio" => $this->post("precio"),
        "descripcion" => $this->post("descripcion"),
        "foto" =>  $Foto
      ]);

      return json(["response" => $Respuesta ? 'ok' : 'error']);
    } else {
      return json(["response" => 'error token']);
    }
  }

  /** Método para eliminado lógico */
  public function SoftDelete(int $id)
  {
    /// validar el token
    if ($this->VerifyTokenCsrf($this->post("_token"))) {
      $model = new Producto;
      $Respuesta = $model->Update([
        "id_producto" => $id,
        "deleted_at" => $this->post("operacion") === 'eliminado_logico' ? $this->FechaActual("Y-m-d H:i:s"):null
      ]);
      return json(['response' => $Respuesta ? 'ok' : 'error']);
    } else {
      return json(['response' => "token-invalidate"]);
    }
  }
  /** Forzar eliminado del producto */
  public function ForceDelete(int $id)
  {
   /// validamos el token
   if ($this->VerifyTokenCsrf($this->post("_token"))) {
    /// eliminamos
    $modelProducto = new Producto;

    $respuesta = $modelProducto->delete($id);

    return json(["response" => $respuesta?'ok':'error']);
   }
   else{
    return json(['response' => "token-invalidate"]);
   }
  }
}
