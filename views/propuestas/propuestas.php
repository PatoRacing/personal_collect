<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-perfil-usuario">
    <div class="contenedor-listar-usuarios">
        <?php if(!$propuestas) { ?>
            <p class="text-center">Aun no hay cartera</p>
        <?php } else { ?>
            <table class="table" id="tabla-search">
                    <thead class="table__thead">
                        <tr>
                            <th scope="col" class="table__th">Nombre</th>
                            <th scope="col" class="table__th">Cliente</th>
                            <th scope="col" class="table__th">Segmento</th>
                            <th scope="col" class="table__th">Producto</th>
                            <th scope="col" class="table__th">Operacion</th>
                            <th scope="col" class="table__th">DNI</th>
                            <th scope="col" class="table__th">Deuda</th>
                            <th scope="col" class="table__th">Fecha</th>
                        </tr>
                    </thead>
                    <tbody id="tabla-search" class="table__body">
                        <?php foreach($propuestas as $propuesta) {?>
                            <tr id="fila">
                                <td class="table__td">
                                    <?php foreach($deudores as $deudor) {?>
                                        <?php if((int)$deudor->id === (int)$propuesta->gestion['deudor_id']) {?>
                                            <?php echo $deudor->nombre; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td class="table__td">
                                    <?php foreach($clientes as $cliente) {?>
                                        <?php if((int)$cliente->id === (int)$propuesta->gestion['cliente_id']) {?>
                                            <?php echo $cliente->nombre; ?>
                                        <?php } ?>
                                    <?php } ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $propuesta->gestion['segmento']; ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $propuesta->gestion['producto']; ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $propuesta->gestion['operacion']; ?>
                                </td>
                                <td class="table__td--operacion">
                                    <?php echo $propuesta->gestion['nro_doc']; ?>
                                </td>
                                <td class="table__td--dni">
                                    $<?php echo $propuesta->gestion['deuda_capital'];  ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $propuesta->gestion['fecha'];  ?>
                                </td>
                            </tr>
                        <?php }?>
                    </tbody>
            </table>
        <?php }?>
    </div>
</div>

<?php @include_once __DIR__ . '/../templates/footer.php'?>