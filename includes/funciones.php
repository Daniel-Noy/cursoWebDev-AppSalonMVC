<?php
declare(strict_types=1);

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//? Funciones de autenticacion
function isAuth(bool $isAdmin = false) : void {
    if ($isAdmin) {
        if (!isAdmin()) header('Location: /');
    }

    if (!isUser()) header('Location: /');
}

function isUser() : bool {
    if (!isset($_SESSION)) {
        session_start();
    }

    return isset($_SESSION['nombre']);
}

function isAdmin() : bool {
    if (!isset($_SESSION)) {
        session_start();
    }

    if (isset($_SESSION['admin'])){
        return boolval($_SESSION['admin']);
    }
    return false;
}

function enRegistro(array $lista, string $id) {
    $registro = array_filter($lista, function($e) use($id){
        return $e['id'] === $id;
    });
    return $registro;
}