<?php 
namespace app\orm;

trait Save 
{
    /** Propiedad tipp array, va almacenar los atributos */
    private array $Atributes = [];

    /** Métodos mágicos */
    public function __set($atributo,$valor):void
    {
        if(!in_array($atributo,$this->Atributes))
        {
            /// asignamos
            $this->Atributes[$atributo] = $valor;
        }
    }
    
    public function __get($atributo):array
    {
        return $this->Atributes[$atributo];
    }

    /** Retornamos los atributos */

    public function getAtributes():array{
        return $this->Atributes;
    }

}