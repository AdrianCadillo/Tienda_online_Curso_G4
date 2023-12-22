<?php

/** Método para obtener las variables de entorno */

function env(string $NameVariable,string $DefectValue="")
{
    if(isset($_ENV[$NameVariable]))
    {
       return $_ENV[$NameVariable]; 
    }

    return  $DefectValue;
}