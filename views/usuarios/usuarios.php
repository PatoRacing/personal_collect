<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/crear-usuario">
        <i class="fa-solid fa-circle-plus"></i>
        Añadir usuario
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
    <?php if(!empty($usuarios)) { ?>

        <input type="text" id="buscador" placeholder="Buscar por nombre o apellido" class="buscador">
        <table class="table">
            <thead class="table__thead">
                <tr>
                    <th scope="col" class="table__th">Nombre</th>
                    <th scope="col" class="table__th">Rol</th>
                    <th scope="col" class="table__th">Estado</th>
                    <th scope="col" class="table__th--acciones">Acciones</th>
                </tr>
            </thead>

            <tbody id="tabla-usuarios" class="table__body">
                <?php foreach($usuarios as $usuario) { ?>
                    <tr class="table__tr">
                        
                        <td class="table__td--nombre">
                            <a href="perfil-usuario?id=<?php echo $usuario->id; ?>"><?php echo $usuario->nombre . " " . $usuario->apellido; ?></a>
                        </td>

                        <td class="table__td">
                            <?php foreach ($roles as $rol) { ?>
                                <?php if ($usuario->roles_id === $rol->id) { ?>
                                <?php echo $rol->rol; ?>
                                <?php }} ?>
                        </td>

                        <td class="table__td" id="tabla-estado">
                            <?php foreach ($estados as $estado) { ?>
                                <?php if ($usuario->estados_id === $estado->id) { ?>
                                    <?php echo $estado->estado; ?>
                                <?php }} ?>
                        </td>
                        
                        <td class="table__td--acciones">
                            <a class="table__accion table__accion--editar" href="editar-usuario?id=<?php echo $usuario->id; ?>">
                            <i class="fa-solid fa-pen-to-square"></i>
                            Editar
                            </a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    
    <?php } else { ?>
            <p class="text-center">No hay usuarios aun</p>
    <?php } ?>
</div>


    <?php @include_once __DIR__ . '/../templates/footer.php'?>
    <?php
    $script .= '<script src="build/js/funciones-listar-usuarios.js"></script>';
    ?>