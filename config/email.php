<?php

/**
 * Configuración para envio de correos
 */
return [
/** Configuración del Host */
"HOST_MAIL" => env("HOST_MAIL"),
/**Configuramos el nombre de usuario del smpt  */
"USER_MAIL" => env("USER_MAIL"),
/**Configuramos el password */
"PASSWORD_MAIL" => env("PASSWORD_MAIL"),

/** SMTP SECURE */
"SMTSECURE_MAIL" => env("SMTSECURE_MAIL"),

/** PUERTO CONFIG */
"PUERTO_MAIL" => env("PUERTO_MAIL"),

/** Configuración para el nombre del correo emisor */

"EMISOR_CORREO_MAIL" => "Soporte@TecnologySoft.pe",
/** Configuración para el nombre del  emisor */

"EMISOR_NAME" => "Soporte"

];