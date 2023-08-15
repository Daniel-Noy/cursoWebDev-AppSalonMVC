<h1 class="nombre-pagina">Actualizar Servicio</h1>
<p class="descripcion-pagina">Llena el formulario para actualizar el servicio</p>

<?php include_once __DIR__ . "/../templates/barra.php" ?>

<form class="formulario" method="POST">

    <?php include_once "formulario.php" ?>
    <div class="botones">    
        <input type="submit" class="boton" value="Actualizar Servicio">
        <a href="/admin/servicios" class="boton-advertencia">Regresar</a>
    </div>
</form>