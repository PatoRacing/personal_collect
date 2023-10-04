<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/perfil-deudor?id=<?php echo $operacion->deudor_id; ?>">
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
<!-- Info del deudor -->
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
</div>

<!--Info de la operacion -->
<div class="contenedor-perfil-usuario">
    <h3>Detalle de la operación</h3>
    <div class="contenedor contenedor-datos-usuario">
        <div>
            <p><span>Cliente: </span>
                <?php foreach ($clientes as $cliente) { ?>
                    <?php if ($cliente->id === $operacion->cliente_id) { ?>
                        <?php echo $cliente->nombre?>
                    <?php }?>
                <?php }?>
            <p><span>Nro. Operacion: </span><?php echo $operacion->operacion; ?></p>
        </div>
        <div>
            <p><span>Segmento: </span><?php echo $operacion->segmento; ?></p>
            <p><span>Producto: </span><?php echo $operacion->producto; ?></p>
        </div>
        <div>
            <p><span>Deuda Capital: </span>$<?php echo $operacion->deuda_capital; ?></p>
            <p><span>Fecha de atraso: </span><?php echo $operacion->fecha_atraso; ?></p>
        </div>
        <div>
            <p><span>Fecha Ult. Pago: </span>
            <?php if (!empty($operacion->fecha_ult_pago)) {
                echo $operacion->fecha_ult_pago;
            } else {
                echo "Sin información";
            } ?>
            <p><span>Días de atraso: </span>
            <?php $fechaAtraso = DateTime::createFromFormat('d/m/Y', $operacion->fecha_atraso);
            $fechaActual = new DateTime();
            $diferencia = $fechaAtraso->diff($fechaActual);
            echo $diferencia->days . ' días';
            ?>
            </p>
        </div>
    </div>
</div>

<!--Gestiones sobre las operaciones -->
<div class="contenedor-perfil-usuario">
    <h3>Gestiones realizadas</h3>
    <div class="contenedor-listar-usuarios">
        <div class="contenedor-perfil-usuario">
            <div class="contenedor-boton-nueva-gestion-deudor">
            <a class="boton" href="/nueva-gestion-operacion?id=<?php echo $operacion->id; ?>">
            <i class="fa-solid fa-circle-plus"></i>
                Nueva gestión
            </a>
        </div>
            <?php if(!$gestionesOperacion) {?>
                <p class="text-center">Aun no se han realizado gestiones sobre esta operación</p>
            <?php } else { ?>
            <table class="table">
                <thead class="table__thead">
                    <tr>
                        <th scope="col" class="table__th">Fecha</th>
                        <th scope="col" class="table__th">Acción</th>
                        <th scope="col" class="table__th">Negociación</th>
                        <th scope="col" class="table__th">Monto neg.</th>
                        <th scope="col" class="table__th">Honorarios</th>
                        <th scope="col" class="table__th">Resumen</th>
                        <th scope="col" class="table__th">Vencimiento</th>
                        <th scope="col" class="table__th">Resultado</th>
                        <th scope="col" class="table__th">Observaciones</th>
                        <th scope="col" class="table__th">Usuario</th>
                    </tr>
                </thead>
                <tbody id="tabla-usuarios" class="table__body">
                    <?php foreach ($gestionesOperacion as $gestionOperacion) {?>
                    <tr id="fila">
                        <td class="table__td">
                            <?php echo formatearFecha($gestionOperacion->fecha)?>
                        </td>
                        <td class="table__td">
                            <?php echo $gestionOperacion->accion?>
                        </td>
                        <td class="table__td">
                            <?php echo $gestionOperacion->tipo_negociacion?>
                        </td>
                        <td class="table__td">
                            $<?php echo $gestionOperacion->monto_negociado?>
                        </td>
                        <td class="table__td">
                            $<?php echo $gestionOperacion->honorarios?>
                        </td>
                        <td class="table__td">
                            <?php if (!empty($gestionOperacion->cant_cuotas) && !empty($gestionOperacion->monto_cuotas)) {
                                echo "Cant. de Cuotas: " . $gestionOperacion->cant_cuotas . "<br>";
                                echo "Monto Cuotas: $" . $gestionOperacion->monto_cuotas;
                            } elseif (!empty($gestionOperacion->porcentaje_quita) && !empty($gestionOperacion->monto_quita)) {
                                echo "% de Quita: " . $gestionOperacion->porcentaje_quita . "%<br>";
                                echo "Quita: $" . $gestionOperacion->monto_quita . "<br>";
                                echo "M. a Pagar: $" . $gestionOperacion->monto_total_a_pagar;
                            }?>
                        </td>
                        <td class="table__td">
                            <?php echo formatearFecha($gestionOperacion->fecha_sugerida)?>
                        </td>
                        <td class="table__td">
                            <span class="situacion <?php echo obtenerClaseSituacion($gestionOperacion->resultado); ?>">
                                <?php echo $gestionOperacion->resultado?>
                            </span>
                        </td>
                        <td class="table__td">
                            <?php echo $gestionOperacion->observaciones?>
                        </td>
                        <td class="table__td">
                            <?php foreach ($usuarios as $usuario) {?>
                                <?php if($usuario->id === $gestionOperacion->usuario_id) {?>
                                    <?php echo $usuario->nombre . ' ' . $usuario->apellido?>
                                <?php }?>
                            <?php }?>
                        </td>
                    </tr>
                    <?php }?>
                    </div>             
                </tbody>
            </table>
            <?php } ?>
        </div>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>

