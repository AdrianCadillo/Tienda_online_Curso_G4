<?php

use Dotenv\Dotenv;
 
require 'vendor/autoload.php';
Dotenv::createImmutable(__DIR__)->load();
require 'app/Controls.php';
require 'storage/debug.php';
require 'autoload.php';
 
