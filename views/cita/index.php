<h1 class="nombre-pagina">Crear Nueva Cita</h1>
<p class="descripcion-pagina">Elige tus servicios a continuacion</p>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div id="app">
    <div class="tabs">
        <button type="button" data-paso="1">Servicios</button>
        <button type="button" data-paso="2">Informacion Cita</button>
        <button type="button" data-paso="3">Resumen</button>
    </div>
    <div id="paso-1" class="seccion">
        <h2>Servicios</h2>
        <p>Elige tus servicios a continuación</p>
        <div id="servicios" class="listado-servicios"></div>
    </div>
    
    <div id="paso-2" class="seccion">
        <h2>Tus datos y Cita</h2>
        <p>Coloca tus datos y fecha de tu cita</p>

        <form class="formulario">
            <div class="campo">
                <label for="nombre">Nombre</label>
                <input type="text"
                id="nombre"
                placeholder="Tu Nombre"
                <?php if( $usuario ) {?>
                value="<?php echo $usuario["nombre"]; ?>"
                <?php } ?>
                >
            </div>
            <div class="campo">
                <label for="fecha">Fecha</label>
                <input type="date"
                id="fecha"
                >
            </div>
            <div class="campo">
                <label for="hora">Hora</label>
                <input type="time"
                id="hora"
                >
            </div>
            <input type="hidden" id="id" value="<?php echo $_SESSION["id"]?>">
        </form>
    </div>

    <div id="paso-3" class="seccion || texto-izquierda">
        <h2>Resumen</h2>
        <p>Verifica que la informacion sea correcta</p>
        <div class="resumen"></div>
    </div>
</div>

<div class="paginacion">
    <button 
        class="boton"
        id="anterior"
    >&laquo; Anterior</button>

    <button 
        class="boton"
        id="siguiente"
    >Siguiente &raquo;</button>
</div>

<?php 
    // $script = "
    // <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    // <script src='/build/js/app.js'></script>
    // "
    
    $script = "
    <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
    <script type='module' src='/build/js/app2.js'></script>
    "
    
?>
