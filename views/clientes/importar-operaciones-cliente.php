<?php @include_once __DIR__ . '/../templates/header.php'?>

<?php
    if($resultado) {
    $mensaje = mostrarNotificacion(intval($resultado));
    if($mensaje) { ?>
    <p class="alerta error"id="notificacion"> <?php echo s($mensaje) ?></p>
    <?php }
    }
?>

<div class="contenedor contenedor-usuario">
    <div class="contenedor-perfil-usuario">
        <h3><?php echo $cliente->nombre; ?></h3>
    </div>
    <div class="contenedor-sm">
        <p class="descripcion-pagina">Importar/actualizar cartera</p>
        <?php @include_once __DIR__ . '/../templates/alertas.php'?>

        
        <form class="formulario" method="POST" action="/importar-operaciones-cliente?id=<?php echo $cliente->id; ?>" enctype="multipart/form-data">

            <div class="campo">
                <label for="cliente">Cliente</label>
                <select name="cliente_id" id="cliente" >
                        <option readonly value="<?php echo s($cliente->id); ?>"><?php echo $cliente->nombre; ?></option>                    
                </select>
            </div>
            <div class="campo">
                <label for="importar">Importar </label>
                <input
                    type="file"
                    id="importar"
                    placeholder="Seleccionar archivo"
                    name="importar"
                    accept=".xls, .xlsx"
                    value="<?php echo s($nombreArchivoSubido); ?>" 
                />
            </div>
            <input type="submit" class="boton" value="Importar cartera">
        </form>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>


