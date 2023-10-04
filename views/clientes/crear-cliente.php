<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/clientes">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="contenedor contenedor-usuario">
    
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Completar todos los campos</p>
        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <form class="formulario" method="POST" action="/crear-cliente">
            <?php @include_once __DIR__ . '/formulario-clientes.php'?>

            <input type="submit" class="boton" value="Crear cliente">
        </form>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>