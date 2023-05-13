<div class="barra">
    <p>Hola <span class="fw-bold"><?php echo $usuario["nombre"] ?? '' ?></span></p>
    <a href="/cuenta/logout" class="boton">Cerrar Sesion</a>
</div>


<?php if( $_SESSION["admin"] === "1" ) { ?>
    <div class="barra-servicios">
        <a href="/admin" class="boton">Ver Citas</a>
        <a href="/admin/servicios" class="boton">Ver servicios</a>
        <a href="/admin/servicios/crear" class="boton">Nuevo Servicio</a>
    </div>

<?php } ?>