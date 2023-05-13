<h1 class="nombre-pagina">Recupera tu contraseña</h1>
<p class="descripcion-pagina">Ingresa la nueva contraseña</p>

<?php require_once __DIR__ . "/../templates/alertas.php"; ?>


<?php if(!$error) {?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password"
            id="password"
            placeholder="Tu Contraseña"
            name="password"
        >
    </div>

    <input class="boton" type="submit" value="Cambiar mi contraseña">
</form>

<?php } else { ?>
    <a href="/" class="boton">Regresar al inicio</a>
<?php } ?>