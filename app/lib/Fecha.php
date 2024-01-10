<?php 
namespace app\lib;
trait Fecha
{
/**Método que retorna la fecha actual */
public function FechaActual(string $formato)
{
 date_default_timezone_set("America/Lima");
 return date($formato);
}
}