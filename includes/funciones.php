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

// Revisa que el usuario este autenticado
// function isAuth() {
//     if(isset($_SESSION["login"])) {
//         header("Location: /citas/agendar");
//     }
// }

// function isAdmin() {
//     if(isset($_SESSION["admin"])) {
//         header("Location: /admin");
//     }
// }

function auth() {
    if( !empty($_SESSION) ) {
        if($_SESSION["admin"] === "1") {
            header("Location: /admin");
        } else if ($_SESSION["login"]) {
            header("Location: /citas/agendar");
        }
    }
}