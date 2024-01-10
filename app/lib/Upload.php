<?php 
namespace app\lib;

trait Upload
{
    use Request;
   /** Propiedades para la subida de imágenes al servidor */
   private array $TypeArchivoAccept = ["image/jpeg","image/png"]; 

   private string $Destino = "assets/dist/foto/";/// destino de la imágen

   private string|null $NombreImagen = null;

   /** Método para subida de imágenes */

   public function UploadImage(string $NombreArchivo):string
   {
    /// validamos si existe un archivo seleccionado
    if($this->file_size($NombreArchivo) > 0)
    {
       /// validar que el archivo seleccionado sea una imágen
       if(in_array($this->file_type($NombreArchivo),$this->TypeArchivoAccept))
       {
        /// verificamos si la carpeta foto existe o no existe
        if(!file_exists($this->Destino))
        {
            mkdir($this->Destino,0777,true);
        }
         //// Asignarle un nuevo nombre a la imágen
         $NameImagen = date("YmdHis").bin2hex(random_bytes(32)).".".pathinfo($this->file_Name($NombreArchivo))['extension'];
         $this->NombreImagen = $NameImagen;
         ///subimos la imágen al servidor
         $this->Destino.=$NameImagen;

         if(move_uploaded_file($this->fileContent($NombreArchivo),$this->Destino))
         {
            return "subido";
         }
         return "error upload";
       }
       else{
        return "archivo-no-accept";
       }
    }
    $this->NombreImagen = null;
    return "vacio";
   }

   /** Retorna nombre de la imágen */
   public function getNOmbreImagen():string|null{
    return $this->NombreImagen;
   }
}