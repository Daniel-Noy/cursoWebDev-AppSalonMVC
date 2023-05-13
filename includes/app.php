<?php 
declare(strict_types=1);

use Dotenv\Dotenv;

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->safeLoad();
require 'funciones.php';
require 'database.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

// Cambiar la zona horaria por defecto
date_default_timezone_set("America/Mexico_City");