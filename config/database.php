<?php

/**
 * Retornamos un array para 
 * la configuración de la base de datos
 */

 return [

    /** Configuración para nombre de usuario */
    "USERNAME" => env("USERNAME","root"),
    "PASSWORD" => env("PASSWORD"),
    "BASEDEDATOS" => env("BASEDEDATOS","app"),
    "PUERTO" => env("PUERTO","3306"),
    "SERVER" => env("SERVER","localhost"),

    "DRIVER_URL" => "mysql:host=".env("SERVER","localhost").":".env("PUERTO","3306").
    ";dbname=".env("BASEDEDATOS","app")
 ];