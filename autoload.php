<?php

use app\lib\Route;

spl_autoload_register(function($file){
$file = str_replace("\\","/",$file).".php";
 if(file_exists($file))
 {
    require_once $file;
 }
});

$route = new Route;

print_r($route->run());