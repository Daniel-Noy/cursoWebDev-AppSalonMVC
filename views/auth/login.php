<h1 class="nombre-pagina">Login</h1>
<p class="descripcion-pagina">Inicia sesion con tus datos</p>

<?php require_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="POST">
    <div class="campo">
        <label for="email">Email</label>
        <input type="email"
            id="email"
            placeholder="Tu Email"
            name="email"
            value="<?php echo s($auth->email)?>"
        >
    </div>

    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password"
            id="password"
            placeholder="Tu Contraseña"
            name="password"
        >
    </div>

    <input class="boton" type="submit" value="Iniciar Sesion">
</form>

<div class="acciones">
    <a href="/cuenta/crear">¿Aún no tienes cuenta? Crear una</a>
    <a href="/cuenta/password/olvide">¿Olvidaste tu contraseña?</a>
</div>