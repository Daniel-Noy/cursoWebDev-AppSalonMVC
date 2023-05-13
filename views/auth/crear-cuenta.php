<h1 class="nombre-pagina">Crea tu cuenta</h1>
<p class="descripcion-pagina">Llena el siguiente formulario para crear tu cuenta</p>

<?php include_once __DIR__ . "/../templates/alertas.php"; ?>

<form class="formulario" method="post">
    <div class="campo">
        <label for="nombre">Nombre</label>
        <input type="text"
            id="nombre"
            placeholder="Tu nombre"
            name="nombre"
            value="<?php echo $usuario->nombre; ?>"
        >
    </div>

    <div class="campo">
        <label for="apellido">Apellido</label>
        <input type="text"
            id="apellido"
            placeholder="Tu apellido"
            name="apellido"
            value="<?php echo s($usuario->apellido); ?>"
        >
    </div>

    <div class="campo">
        <label for="telefono">Telefono</label>
        <input type="tel"
            id="telefono"
            placeholder="No. Telefono"
            name="telefono"
            value="<?php echo s($usuario->telefono); ?>"
        >
    </div>
    
    <div class="campo">
        <label for="email">Email</label>
        <input type="email"
            id="email"
            placeholder="Tu direccion de correo"
            name="email"
            value="<?php echo s($usuario->email); ?>"
        >
    </div>
    
    <div class="campo">
        <label for="password">Contraseña</label>
        <input type="password"
            id="password"
            placeholder="Ingresa una contraseña"
            name="password"
        >
    </div>

    <input class="boton" type="submit" value="Crear Cuenta">
</form>

<div class="acciones">
    <a href="/">¿Ya tienes cuenta? Inicia Sesión</a>
    <a href="/cuenta/password/olvide">¿Olvidaste tu contraseña?</a>
</div>