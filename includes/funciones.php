<?php

require 'app.php';

function incluirTemplate( string $nombre, bool $inicio = false ) {
    include TEMPLATES_URL . "/${nombre}.php";
}

function estaAutenticado() : bool {
    session_start();

    $auth = $_SESSION['login'];
    if($auth) {
        return true;
    }
    return false;
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