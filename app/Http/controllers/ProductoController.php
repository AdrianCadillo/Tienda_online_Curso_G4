<?php

use app\lib\BaseController;
use app\lib\pdf;
use app\lib\Upload;
use app\models\Producto;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

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

  /** Reporte de productos en pdf */
  public function reporte()
  {
    $Total_Precios = 0.00;
    $pdf = new pdf();
    $pdf->AliasNbPages();
    /// vamos asignarle un título al pdf
    $pdf->SetTitle("reporte-productos");
    /// agregar una nueva página
    $pdf->AddPage();

    $pdf->Image(asset("dist/img/AdminLTELogo.png"),10,15,50,50);
    /// agregamos la fecha
    $pdf->SetFont("Arial","B",12);
    $pdf->Ln(12);
    $pdf->SetX(140);
    $pdf->Cell(18,10,"Fecha",1,0,"L");
    $pdf->Cell(26,10,$this->FechaActual("d/m/Y"),1,1,"L");

    /** Columnas de la tabla */
    $pdf->Ln(20);
    /** Indicamos los estilos para esa columna */
    $pdf->SetFont("Arial","B",12);
    $pdf->SetTextColor(248, 248, 255);
    $pdf->SetFillColor(65, 105, 225);
    $pdf->SetDrawColor(0, 255, 127);
    $pdf->SetX(25);
    $pdf->Cell(32,10,utf8_("CÓDIGO"),1,0,"L",true);
    $pdf->Cell(100,10,"PRODUCTO",1,0,"L",true);
    $pdf->Cell(32,10,"PRECIO",1,1,"L",true);

    /** Recuperar los datos de la tabla productos */
    $model = new Producto;

    $Productos = $model->initQuery()->get();

    /** darle estilo al body de la tabla */
    $pdf->SetFont("Arial","",10);
    $pdf->SetTextColor(0,0,0);
    $pdf->SetFillColor(248, 248, 255); 
    foreach($Productos as $producto)
    {
      $Total_Precios+=$producto->precio;
      $pdf->SetX(25);
      $pdf->Cell(32,10,$producto->id_producto,1,0,"L",true);
      $pdf->Cell(100,10,utf8_("$producto->nombre_producto"),1,0,"L",true);
      $pdf->Cell(32,10,$producto->precio." USD",1,1,"L",true);
    }
    $pdf->SetX(25);
    $pdf->Cell(132,10,"Total en precio ",1,0,"L");
    $pdf->Cell(32,10,number_format($Total_Precios,2,',',' ')." USD",1,1,"L");
    /** Ejecutar el pdf */

    $pdf->Output();
  }

  /** Método para reporte excel de productos */
  public function reporte_excel()
  {
    /** Verificamos el token */
    if($this->VerifyTokenCsrf($this->post("_token")))
    {

      /** Asignamos un nombre al reporte excel */
      $Reporte_name_Excel = "reporte_productos".$this->FechaActual("YmdHis").rand();

      /** Instanciar la libreria  */
      $Excel = new Spreadsheet;

      /**Creamos una hoja para el reporte */

      $FileExcel = $Excel->getActiveSheet();

      /** le asignamos un titulo a la hoja */
      $FileExcel->setTitle("reporte-productos");
      /** Mostramos los productos */
       /** Recuperar los datos de la tabla productos */
      $model = new Producto;

      $Productos = $model->initQuery()->get();

      /** Creamos las columnas de la tabla en el excel */
      $FileExcel->setCellValue("A1","CODIGO");
      $FileExcel->setCellValue("B1","PRODUCTO");
      $FileExcel->setCellValue("C1","PRECIO");

      $Fila = 2;

      foreach($Productos as $producto)
      {
      $FileExcel->setCellValue("A".$Fila,$producto->id_producto);
      $FileExcel->setCellValue("B".$Fila,utf8_($producto->nombre_producto));
      $FileExcel->setCellValue("C".$Fila,$producto->precio);

      $Fila++;
      }

      /// Forzamos la descarga automática del reporte
      /* Here there will be some code where you create $spreadsheet */

      // redirect output to client browser
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header('Content-Disposition: attachment;filename="'.$Reporte_name_Excel.'.xlsx"');
      header('Cache-Control: max-age=0');
      ob_end_clean();
      $writer = IOFactory::createWriter($Excel, 'Xlsx');
      $writer->save('php://output');

      exit;
    }
  }
}
