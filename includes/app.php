<?php 
declare(strict_types=1);

require 'funciones.php';
require 'database.php';
require __DIR__ . '/../vendor/autoload.php';

// Conectarnos a la base de datos
use Model\ActiveRecord;
ActiveRecord::setDB($db);

// Cambiar la zona horaria por defecto
date_default_timezone_set("America/Mexico_City");