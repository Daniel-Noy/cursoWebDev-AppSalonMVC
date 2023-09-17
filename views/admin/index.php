<h1 class="nombre-pagina">Panel de administración</h1>

<?php include_once __DIR__ . '/../templates/barra.php' ?>

<div class="busqueda">
    <h2>Buscar Citas</h2>

    <form class="formulario">
        <div class="campo">
            <label for="fecha">Fecha</label>
            <input type="date"
            id="fecha"
            name="fecha">
        </div>
    </form>
</div>

<div id="citas-container">
    <span class="loader"></span>
</div>

<?php //$script = "
// <script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
// <script src='build/js/admin.js'></script>
// "
?>
<?php $script = "
<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
<script type='module' src='build/js/admin.js'></script>
"
?>