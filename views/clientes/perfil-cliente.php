<?php @include_once __DIR__ . '/../templates/header.php'?>

    <div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/clientes">
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

    <div class="contenedor-perfil-usuario">
        <h3><?php echo $cliente->nombre; ?></h3>
        <div class="contenedor contenedor-datos-usuario">
            <div>
                <p><span>Domicilio: </span> <?php echo $cliente->domicilio; ?></p>
                <p><span>Localidad: </span><?php echo $cliente->localidad; ?></p>
            </div>

            <div>
                <p><span>Código Postal: </span> <?php echo $cliente->codigoPostal; ?></p>
                <p><span>Email: </span> <?php echo $cliente->email; ?></p>
            </div>

            <div>
                <p><span>Contacto: </span><?php echo $cliente->contacto; ?></p>
                <p><span>Telefono: </span> <?php echo $cliente->telefono; ?></p>
            </div>
        </div>
        <div class="contenedor-listar-usuarios">
            <div class="contenedor-perfil-usuario">
                <div class="contenedor-boton-importar-cartera">
                    <a class="boton" href="/importar-operaciones-cliente?id=<?php echo $cliente->id; ?>">
                    <i class="fa-solid fa-file-import"></i>
                        Importar
                    </a>
                </div>
                <div class="contenedor contenedor-datos-usuario">
                    <p><span>Total Casos: </span><?php echo $totalCasos; ?></p>
                    <p><span>Casos Activo: </span><?php echo $casosActivosTotal; ?></p>
                    <p><span>Total DNI: </span> <?php echo $cantidadDniUnicos; ?></p>
                    <p><span>Total Deuda: </span>$<?php echo number_format($deudaTotal, 2, ',', '.'); ?></p>
                    <p><span>Deuda Activa: </span>$<?php echo number_format($deudaActivaTotal, 2, ',', '.'); ?></p>
                </div>
                    <input type="text" id="buscador2" placeholder="Buscar por nombre, DNI u operación" class="buscador">
                    <?php if(empty($carteraCliente)) { ?>
                        <p class="text-center">El cliente no tiene cartera</p>
                    <?php } else { ?>
                        <table class="table">
                            <thead class="table__thead">
                                <tr>
                                    <th scope="col" class="table__th">Nombre</th>
                                    <th scope="col" class="table__th">Segmento</th>
                                    <th scope="col" class="table__th">Producto</th>
                                    <th scope="col" class="table__th">Operacion</th>
                                    <th scope="col" class="table__th">DNI</th>
                                    <th scope="col" class="table__th">Deuda</th>
                                    <th scope="col" class="table__th">Estado</th>
                                </tr>
                            </thead>
                            <tbody id="tabla-usuarios" class="table__body">
                            <?php foreach($carteraCliente as $cartera) {?>
                                <tr class="table__tr <?php foreach($estados as $estado) {
                                    if($estado->id === $cartera->estados_id && $estado->estado === 'Inactivo') {
                                        echo 'inactivo'; // Agrega una clase CSS llamada "inactivo" si el estado es "Inactivo"
                                    }
                                }?>">
                                    <td class="table__td--nombre">
                                    <a href="/perfil-deudor?id=<?php echo $cartera->deudor_id; ?>">
                                        <?php foreach ($deudores as $deudor){?>
                                            <?php if($deudor->id === $cartera->deudor_id){?>
                                                <?php $nombreAcortado = strlen($deudor->nombre) > 15 ? substr($deudor->nombre, 0, 15) . '...' : $deudor->nombre; ?>
                                                <?php echo $nombreAcortado; ?>
                                            <?php }?>
                                        <?php }?>
                                    </a>
                                    </td>
                                    <td class="table__td">
                                        <?php echo $cartera->segmento; ?>
                                    </td>
                                    <td class="table__td">
                                        <?php
                                        $producto = $cartera->producto;
                                        $productoAcortado = strlen($producto) > 15 ? substr($producto, 0, 15) . '...' : $producto;
                                        echo $productoAcortado;
                                        ?>
                                    </td>
                                    <td class="table__td--operacion">
                                        <?php echo $cartera->operacion; ?>
                                    </td>
                                    <td class="table__td--dni">
                                        <?php echo $cartera->nro_doc; ?>
                                    </td>
                                    <td class="table__td">
                                        $<?php echo $cartera->deuda_activa; ?>
                                    </td>
                                    <td class="table__td ">
                                        <?php foreach($estados as $estado) {?>
                                            <?php if($estado->id === $cartera->estados_id){; ?>
                                                <?php echo $estado->estado?>
                                            <?php }?>
                                        <?php }?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>

                        </table>
                    <?php } ?>
                </div>
            </div>

    
    

    

<?php @include_once __DIR__ . '/../templates/footer.php'?>

<?php
    $script .= '<script src="build/js/listar-cartera-cliente.js"></script>';
?>