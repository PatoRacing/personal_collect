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
        <form class="formulario" method="POST" >
            <?php @include_once __DIR__ . '/formulario.php'?>
            <div class="campo">
                <label for="estado">Estado</label>
                <select name="estados_id" id="estado">
                <option selected value=""> - Seleccionar -</option>
                <?php foreach ($estados as $estado) { ?>
                <option
                <?php echo $usuario->estados_id === $estado->id ? 'selected' : '';?>
                value="<?php echo s($estado->id); ?>">
                <?php echo $estado->estado; ?>
                </option>
                <?php } ?>
                </select>                
            </div>
                <input type="submit" class="boton" value="Editar usuario">
        </form>
    </div>
</div>


<?php @include_once __DIR__ . '/../templates/footer.php'?>