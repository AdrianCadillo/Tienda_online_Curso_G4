<?php

use Dotenv\Dotenv;
 
require 'vendor/autoload.php';
Dotenv::createImmutable(__DIR__)->load();
require 'app/Controls.php';
require 'storage/debug.php';
/// incorporamos la libreria fpdf
require_once 'app/fpdf/fpdf.php';
require 'autoload.php';
 
