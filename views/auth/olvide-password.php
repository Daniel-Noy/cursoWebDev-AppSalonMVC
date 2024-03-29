<h1 class="nombre-pagina">Recuperar contraseña</h1>
<h1 class="nombre-pagina">Por efectos de demostración, el reestablecimiento de la contraseña esta deshabilitado</h1>
<p class="descripcion-pagina">Ingresa el correo electronico con el quieres iniciar sesión</p>


<?php require_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            disabled //? Confirmación deshabilitada para la demostración
        >
    </div>

    <input disabled //? Confirmación deshabilitada para la demostración
    class="boton" type="submit" value="Enviar instrucciones">
</form>

<div class="acciones">
    <a href="/cuenta/crear">¿Aún no tienes cuenta? Crear una</a>
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
</div>