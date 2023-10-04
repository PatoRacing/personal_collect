<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-perfil-usuario">
    <div class="contenedor-listar-usuarios">
        <div class="contenedor contenedor-datos-usuario">
            <p><span>Total Casos: </span><?php echo $totalCasos; ?></p>
            <p><span>Total DNI: </span> <?php echo $cantidadDniUnicos; ?></p>
            <p><span>Total Deuda: </span>$<?php echo number_format($deudaActivaTotal, 2, ',', '.'); ?></p>
        </div>
        <input type="text" id="search" placeholder="Buscar por nombre, cliente, DNI u operación" class="buscador">
        <?php if(empty($carteras)) { ?>
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
                        </tr>
                    </thead>
                    <tbody id="tabla-search" class="table__body">
                        <?php foreach($carteras as $cartera) {?>
                            <?php if ($cartera->estados_id === 1) {?>
                            <tr id="fila">
                                <td class="table__td--nombre">
                                <a href="/perfil-deudor?id=<?php echo $cartera->deudor_id; ?>">
                                    <?php foreach ($deudores as $deudor) {; ?>
                                        <?php if($deudor->id === $cartera->deudor_id) { ?>
                                            <?php $nombreAcortado = strlen($deudor->nombre) > 15 ? substr($deudor->nombre, 0, 15) . '...' : $deudor->nombre; ?>
                                            <?php echo $nombreAcortado; ?>
                                        <?php }?>
                                    <?php }?>
                                    </a>
                                </td>
                                <td class="table__td--cliente">
                                    <?php foreach ($clientes as $cliente) {; ?>
                                        <?php if($cliente->id === $cartera->cliente_id) { ?>
                                            <?php echo $cliente->nombre?>
                                        <?php }?>
                                    <?php }?>
                                </td>
                                <td class="table__td">
                                    <?php echo $cartera->segmento; ?>
                                </td>
                                <td class="table__td">
                                    <?php echo $cartera->producto; ?>
                                </td>
                                <td class="table__td--operacion">
                                    <?php echo $cartera->operacion; ?>
                                </td>
                                <td class="table__td--dni">
                                    <?php echo $cartera->nro_doc; ?>
                                </td>
                                <td class="table__td">
                                    $<?php echo $cartera->deuda_total; ?>
                                </td>
                            </tr>
                            <?php }?>
                        <?php }?>
                    </tbody>
            </table>
        <?php }?>
    </div>
</div>


<?php @include_once __DIR__ . '/../templates/footer.php'?>

<?php
    $script .= '<script src="build/js/funciones-listar-cartera.js"></script>';
?>