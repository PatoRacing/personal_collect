<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/cartera">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
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
<!-- Info del deudor-->
<div class="contenedor-perfil-usuario">
    <h3><?php echo $deudor->nombre; ?></h3>
    
    <div class="contenedor contenedor-datos-usuario">
        <div>
            <p><span>Teléfono: <br> </span><?php echo $deudor->telefono; ?></p>
        </div>

        <div>
            <p><span>Email: <br> </span><?php echo $deudor->email; ?></p>
        </div>

        <div>
            <p><span>Documento: <br> </span><?php echo $deudor->tipo_doc . " " . formatearDNI($deudor->nro_doc); ?></p>
        </div>

        <div>
            <p><span>Domicilio: <br> </span><?php echo $deudor->domicilio . " " . "(" . $deudor->localidad . "- CP: $deudor->codigo_postal)"; ?></p>  
        </div>
    </div>
    <div class="contenedor-boton-importar-cartera">
        <a class="boton" href="actualizar-deudor?id=<?php echo $deudor->id;?>">
        <i class="fa-solid fa-file-import"></i>
            Editar perfil
        </a>
    </div>
</div>

<!--Info de gestiones sobre el deudor -->
<div class="contenedor-perfil-usuario">
    <h3>Gestiones sobre el deudor</h3>
    <div class="contenedor-listar-usuarios">
        <div class="contenedor-perfil-usuario">
            <div class="contenedor-boton-nueva-gestion-deudor">
            <a class="boton" href="gestion-deudor?id=<?php echo $deudor->id;?>">
            <i class="fa-solid fa-circle-plus"></i>
                Nueva gestión
            </a>
            </div>
            <?php if(!$gestionesDeudor) {?>
                <p class="text-center">Aun no se han realizado gestiones sobre el deudor</p>
            <?php } else { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Fecha</th>
                        <th scope="col" class="table__th">Acción</th>
                        <th scope="col" class="table__th">Resultado</th>
                        <th scope="col" class="table__th">Usuario</th>
                        <th scope="col" class="table__th">Observaciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-usuarios" class="table__body">
                <?php foreach($gestionesDeudor as $gestionDeudor) {?>
                    <tr id="fila">
                        <td class="table__td">
                            <?php echo formatearFecha($gestionDeudor->fecha); ?>
                        </td>
                        <td class="table__td">
                            <?php echo $gestionDeudor->accion; ?>
                        </td>
                        <td class="table__td">
                            <span class="situacion <?php echo obtenerClaseSituacion($gestionDeudor->resultado); ?>">
                            <?php echo $gestionDeudor->resultado; ?>
                            </span>
                        </td>
                        <td class="table__td">
                            <?php foreach ($usuarios as $usuario) { ?>
                                <?php if($gestionDeudor->usuario_id === $usuario->id) { ?>
                                    <?php echo $usuario->nombre . " " . $usuario->apellido; ?>
                                <?php } ?>
                            <?php } ?>
                        </td>
                        
                        <td class="table__td">
                            <?php echo $gestionDeudor->observaciones; ?>
                        </td>
                    </tr>
                <?php } ?>
                
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>

<!-- Operaciones del deudor -->
<div class="contenedor-perfil-usuario">
    <h3>Operaciones</h3>
    <div class="contenedor-listar-usuarios">
        <div class="contenedor-perfil-usuario">
            <?php if(!$cartera) {?>
                <p class="text-center">Este deudor no tiene operaciones activas</p>
            <?php } else { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Operacion</th>
                        <th scope="col" class="table__th">Cliente</th>
                        <th scope="col" class="table__th">Segmento</th>
                        <th scope="col" class="table__th">Producto</th>
                        <th scope="col" class="table__th">Deuda Capital</th>
                        <th scope="col" class="table__th">Situacion</th>
                        <th scope="col" class="table__th">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tabla-usuarios" class="table__body">
                <?php foreach($cartera as $carteraCliente) {?>
                    <tr id="fila">
                        <td class="table__td">
                            <?php echo $carteraCliente->operacion; ?>
                        </td>
                        <td class="table__td">
                            <?php foreach ($clientes as $cliente) {; ?>
                                <?php if($cliente->id === $carteraCliente->cliente_id){?>
                                    <?php echo $cliente->nombre?>
                                <?php }?>
                            <?php }?>
                        </td>
                        <td class="table__td">
                            <?php echo $carteraCliente->segmento; ?>
                        </td>
                        <td class="table__td">
                            <?php echo $carteraCliente->producto; ?>
                        </td>
                        <td class="table__td">
                            $<?php echo $carteraCliente->deuda_capital; ?>
                        </td>
                        <td class="table__td ">
                            <?php 
                            $tieneResultado = false;
                            $claseSituacion = '';
                            foreach ($ultimosRegistros as $ultimoRegistro) {
                                if ($ultimoRegistro->operacion_id === $carteraCliente->id) {
                                    $claseSituacion = obtenerClaseSituacion($ultimoRegistro->resultado);
                                    if ($ultimoRegistro->resultado !== "Sin Gestión") {
                                        echo '<span class="situacion ' . $claseSituacion . '">';
                                    }
                                    echo $ultimoRegistro->resultado;
                                    if ($ultimoRegistro->resultado !== "Sin Gestión") {
                                        echo '</span>';
                                    }
                                    $tieneResultado = true;
                                    break; 
                                }
                            }
                            if (!$tieneResultado) {
                                $claseSituacion = obtenerClaseSituacion("Sin Gestión");
                                echo '<span class="situacion ' . $claseSituacion . '">';
                                echo "Sin Gestión";
                                echo '</span>';
                            }
                            ?>
                        </td>

                        <td class="table__td">
                            <div class="contenedor-boton-editar-situacion-operacion">
                                <a href= "/gestion-operacion?id=<?php echo $carteraCliente->id; ?>">
                                <i class="fa-solid fa-file-import"></i>
                                    Ver gestiones
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php } ?>
                
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>
<?php
    $script .= '<script src="build/js/perfil-deudor.js"></script>';
?>