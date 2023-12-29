
<?php 

/** retornar un array de la configuración de la aplicación */
return [
    
  "BASE_URL" => env("BASE_URL","http://localhost"),

  /**
   * Configuración del app name
   */
  "APP_NAME" => env("APP_NAME","App"),

  /** 
   * Configuración del debug
   */
  "DEBUG_APP" => env("DEBUG_APP",false),

 /** configuración para el directorio de asset */

 "DIRECTORIO_ASSET" => env("DIRECTORIO_ASSET","assets/"),

 /** Configuramos el directorio componente */

 "DIRECTORIO_COMPONENTE" => env("DIRECTORIO_COMPONENTE","resources.views.components."),

 /** Configuración del directorio layout */

 "DIRECTORIO_LAYOUT" => env("DIRECTORIO_LAYOUT","resources.views.layout.")
];
 

