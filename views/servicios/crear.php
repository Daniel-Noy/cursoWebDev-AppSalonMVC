<h1 class="nombre-pagina">Nuevo Servicio</h1>
<p class="descripcion-pagina">Llena todos los campos para agregar un servicio</p>

<?php include_once __DIR__ . "/../templates/alertas.php" ?>

<form class="formulario" method="POST">

    <?php include_once "formulario.php" ?>
    <input type="submit" class="boton" value="Guardar Servicio">
</form>
<a href="/admin" class="boton">Regresar</a>