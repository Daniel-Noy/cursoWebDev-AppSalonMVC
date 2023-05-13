<h1 class="nombre-pagina">Panel de administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div class="busqueda">
    <h2>Buscar Citas</h2>

    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date"
            id="fecha"
            name="fecha"
            value="<?php echo $fecha?>">
        </div>
    </form>
</div>

<?php if(empty($citas)) { ?>
    <h3>Aun no hay citas agendadas este día</h3>
<?php } ?>

<div id="citas-admin">
    <ul class="citas">
    <?php 
    foreach($citas as $key => $cita) { 
        if($idCita !== $cita->id) { 
            $total = 0;
    ?>
        <li>
        <p>ID: <span><?php echo $cita->id; ?></span></p>
        <p>Hora: <span><?php echo $cita->hora; ?></span></p>
        <p>Cliente: <span><?php echo $cita->cliente; ?></span></p> 
        <p>Email: <span><?php echo $cita->email; ?></span></p> 
        <p>Telefono: <span><?php echo $cita->telefono; ?></span></p> 

        <h3>Servicios</h3>
    <?php 
    $idCita = $cita->id;
        } // FIN del if
    ?>
        <p class="servicio"><?php echo "{$cita->servicio}: {$cita->precio}" ?></p>
    <?php 
    $total += $cita->precio;
    $citaActual = $cita->id;
    $citaSiguiente = $citas[$key +1]->id ?? NULL;

    if($citaSiguiente !== $citaActual) { ?>
        <p class="total-servicios">Total: $<?php echo $total; ?></p>

        <form class="eliminar-cita" action="/api/eliminar" method="POST">
            <input type="hidden" name="id" value="<?php echo $cita->id?>">
            <input type="submit" class="boton-eliminar" value="Eliminar">
        </form>
    <?php } ?>
    <?php } //Final del foreach ?>
    </ul>
</div>

<?php $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script src='build/js/admin.js'></script>
"
?>