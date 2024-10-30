<?php

define('TEMPLATES_URL', __DIR__ . '/templates');
define('FUNCIONES_URL', __DIR__ . 'funciones.php');
define('CARPETA_IMAGENES', __DIR__ . '/../imagenes/');


function incluirTemplate( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado() {
    session_start();

    if(!$_SESSION['login']) {
        header('Location: /');
    }
}

function debuguear($variable) {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa el del HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

// Funcion si se usa en el subdirectorio APACHE 🪶
function obtenerNombreDirectorioTrabajo(string $ruta){
    // Obtenemos la ruta completa del directorio principal y reemplazamos las barras invertidas por diagonales en caso de usar Windows
    $ruta_completa = str_replace("\\", "/", dirname(__DIR__));

    // Dividimos la ruta completa en partes usando la barra diagonal como delimitador
    $partes_ruta = explode("/", $ruta_completa);

    // Obtenemos el nombre del directorio principal (el último elemento del array de partes de la ruta)
    $ultimo_directorio = end($partes_ruta);

    // Concatenamos el nombre del directorio principal con la parte específica de la ruta y la retornamos
    return "/" . $ultimo_directorio . $ruta;
}
/* Se usa de esta manera 👇

<link rel="stylesheet" href="<?php echo obtenerNombreDirectorioTrabajo("/build/css/app.css") ?>">

*/