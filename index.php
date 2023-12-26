<?php

use Dotenv\Dotenv;
 
require 'vendor/autolosad.php';
require 'config/app.php';
require 'app/Controls.php';
require 'autoload.php';
 
Dotenv::createImmutable(__DIR__)->load();
