<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/crear-cliente">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir cliente
    </a>
</div>

<?php
    if($resultado) {
    $mensaje = mostrarNotificacion(intval($resultado));
    if($mensaje) { ?>
    <p class="alerta exito"id="notificacion"> <?php echo s($mensaje) ?></p>
    <?php }
    }
?>

<div class="contenedor-listar-usuarios">
    <?php if(!empty($clientes)) { ?>

        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Usuario Últ. Modif.</th>
                    <th scope="col" class="table__th">Últ. Modif.</th>
                    <th scope="col" class="table__th--acciones">Acciones</th>
                </tr>
            </thead>

            <tbody id="tabla-usuarios" class="table__body">
                <?php foreach($clientes as $cliente) { ?>
                    <tr class="table__tr">
                        
                        <td class="table__td--nombre">
                            <a href="/perfil-cliente?id=<?php echo $cliente->id; ?>"><?php echo $cliente->nombre; ?></a>
                        </td>

                        <td class="table__td">
                            <?php foreach ($usuarios as $usuario) { ?>
                                <?php if($cliente->usuarios_id === $usuario->id) { ?>
                                    <?php echo $usuario->nombre . " " . $usuario->apellido; ?>
                                <?php } ?>
                            <?php } ?>
                        </td>

                        <td class="table__td">
                            <?php echo formatearFecha($cliente->ultModificacion); ?>
                        </td>
                        
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="editar-cliente?id=<?php echo $cliente->id; ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Editar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    
    <?php } else { ?>
            <p class="text-center">No hay clientes aun</p>
    <?php } ?>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>

<?php
    $script .= '<script src="build/js/funciones-listar-clientes.js"></script>';
    ?>