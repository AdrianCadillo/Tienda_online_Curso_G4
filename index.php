<?php

use Dotenv\Dotenv;

require 'autoload.php';
require 'vendor/autoload.php';
require 'app/Controls.php';

Dotenv::createImmutable(__DIR__)->load();
