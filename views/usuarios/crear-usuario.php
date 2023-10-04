<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/usuarios">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="contenedor contenedor-usuario">
    
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Completar todos los campos</p>
        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <form class="formulario" method="POST" action="/crear-usuario">
            <?php @include_once __DIR__ . '/formulario.php'?>

            <div class="campo">
                <label for="password">Password</label>
                <input
                type="password"
                id="password"
                placeholder="Debe contener al menos 6 letras, una mayúscula y un signo especial"
                name="password"
                oninput="mostrarCaracteres(this)"
                />
            </div>
            <div class="campo">
                <label for="password2">Repetir password</label>
                <input
                type="password"
                id="password2"
                placeholder="Repite tu password"
                name="password2"
                oninput="mostrarCaracteres2(this)"
                />
            </div>
            <input type="submit" class="boton" value="Crear usuario">
            </form>
    </div>
</div>


<?php @include_once __DIR__ . '/../templates/footer.php'?>
<?php
    $script .= '<script src="build/js/mostrar-password.js"></script>';
    $script .= '<script src="build/js/mostrar-password2.js"></script>';
?>