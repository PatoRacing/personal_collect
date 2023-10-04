<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/perfil-deudor?id=<?php echo $deudor->id; ?>">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="contenedor contenedor-usuario">
    
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Completar todos los campos</p>
        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <form class="formulario" method="POST" >
            <?php @include_once __DIR__ . '/formulario-gestion-deudor.php'?>
                <input type="submit" class="boton" value="Nueva gestión">
        </form>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>