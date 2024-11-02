<?php

use App\Propiedad;

    require '../../includes/app.php';

    estaAutenticado();

    // Validar la URL por ID válido
    $id = $_GET['id'];
    $id = filter_var($id, FILTER_VALIDATE_INT);

    if(!$id) {
        header('Location: /admin');
    }

    // Obtener los datos de la propiedad
    $propiedad = Propiedad::find($id);

    // Consultar para obtener los vendedores
    $consulta = "SELECT * FROM vendedores";
    $resultado = mysqli_query($db, $consulta);

    // Arreglo con manejo de errores
    $errores = [];


    // Ejecutar el código después de que el usuario envia el formulario 
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        
        // Asignar los atributos
        $args = $_POST['propiedad'];

        $propiedad->sincronizar($args);

        debuguear($propiedad);
        
        // Asignar files hacia una variable
        $imagen = $_FILES['imagen'];
        


        if(!$titulo) {
            $errores[] = "Debes añadir un titulo";
        }

        if(!$precio) {
            $errores[] = 'El Precio es Obligatorio';
        }

        if( strlen( $descripcion ) < 50 ) {
            $errores[] = 'La descripción es obligatoria y debe tener al menos 50 caracteres';
        }

        if(!$habitaciones) {
            $errores[] = 'El Número de habitaciones es obligatorio';
        }
        
        if(!$wc) {
            $errores[] = 'El Número de Baños es obligatorio';
        }

        if(!$estacionamiento) {
            $errores[] = 'El Número de lugares de Estacionamiento es obligatorio';
        }
        
        if(!$vendedorId) {
            $errores[] = 'Elige un vendedor';
        }

        // Validar por tamaño (1mb máximo)
        $medida = 1000 * 1000;
        if($imagen['size'] > $medida ) {
            $errores[] = 'La Imagen es muy pesada';
        }

        // echo "<pre>";
        // var_dump($errores);
        // echo "</pre>";


        // Revisar que el array de errores este vacio
        
        if(empty($errores)) {

            // Crear carpeta
            $carpetaImagenes = '../../imagenes/';

            if(!is_dir($carpetaImagenes)) {
                mkdir($carpetaImagenes);
            }

            $nombreImagen = '';

            /** SUBIDA DE ARCHIVOS */

            if($imagen['name']) {
                // Eliminar la imagen previa

                unlink($carpetaImagenes . $propiedad['imagen']);

                // // Generar un nombre único
                $nombreImagen = md5( uniqid( rand(), true ) ) . ".jpg";

                // // Subir la imagen
                move_uploaded_file($imagen['tmp_name'], $carpetaImagenes . $nombreImagen );
            } else {
                $nombreImagen = $propiedad['imagen'];
            }

            

            // Insertar en la base de datos
            $query = " UPDATE propiedades SET titulo = '${titulo}', precio = '${precio}', imagen = '${nombreImagen}', descripcion = '${descripcion}', habitaciones = ${habitaciones}, wc = ${wc}, estacionamiento = ${estacionamiento}, vendedorId = ${vendedorId} WHERE id = ${id} ";

            // echo $query;
            

            $resultado = mysqli_query($db, $query);

            if ($resultado){
                // echo "Insertado Correctamente";

                // Redireccionar al usuario.
                header('Location: /admin?resultado=1');
            }
        }


        
    }

    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Actualizar Propiedad</h1>
        
        <a href="/admin" class="boton boton-verde">Volver</a>

        <?php foreach($errores as $error): ?>
            <div class="alerta error">
                <?php echo $error; ?>
            </div>
        <?php endforeach; ?>
    
        <form class="formulario" method="POST" enctype="multipart/form-data">
            <?php include '../../includes/templates/formulario_propiedades.php';  ?>

            <input type="submit" value="Actualizar Propiedad" class="boton boton-verde">
        </form>
    </main>


<?php 
    incluirTemplate('footer');
?>