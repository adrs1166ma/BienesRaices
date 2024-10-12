<?php

    $resultado = $_GET['resultado'] ?? null;

    require '../includes/funciones.php';    
    incluirTemplate('header');
?>

    <main class="contenedor seccion">
        <h1>Administrador de Bienes Raices</h1>
        <?php if(intval($resultado) === 1): ?>
            <p class="alerta exito">Anuncio creado correctamente</p>
        <?php endif; ?>
            
        <a href="/admin/propiedades/crear.php" class="boton boton-verde">Nueva Propiedad</a>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Titulo</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody>
                
                <tr>
                    <td>1</td>
                    <td>Casa en la playa</td>
                    <td> <img src="/imagenes/27f78a775526af6b4cb6fad9768e950f.jpg" class="imagen-tabla"> </td>
                    <td>$12000</td>
                    <td>                        
                        <a href="" class="boton-rojo-block">Eliminar</a>
                        <a href="" class="boton-amarillo-block">Actualizar</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </main>

<?php 
    incluirTemplate('footer');
?>