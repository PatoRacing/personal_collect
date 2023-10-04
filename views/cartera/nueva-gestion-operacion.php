<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/gestion-operacion?id=<?php echo $id; ?>">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="contenedor-perfil-usuario">
    <h3>Detalle de la operación</h3>
    <div class="contenedor contenedor-datos-usuario">
        <p><span>Segmento: </span><?php echo $operacion->segmento; ?></p>
        <p><span>Producto: </span><?php echo $operacion->producto; ?></p>
        <p><span>Deuda Capital: </span>$<?php echo $operacion->deuda_capital; ?></p>
        <p><span>Honorarios: </span><?php echo $porcentajeHonorarios; ?>%</p>
    </div>
    <!-- Paso 1 -->
    <div class="contenedor">
        <h4>Ingresá la información requerida para la negociación</h4>
        <form action="/nueva-gestion-operacion?id=<?php echo $id; ?>" class="formulario-ventana" method="POST">
            <div class="campo">
                <label for="monto_negociado">Monto negociado</label>
                <input
                type="text"
                id="monto_negociado"
                placeholder="Ingresá el monto de negociación"
                name="monto_negociado"
                value = "<?php echo $monto_negociado; ?>"
                />
            </div>
            <div class="campo">
                <label for="cant_cuotas">Cantidad de cuotas</label>
                <input
                type="text"
                id="cant_cuotas"
                placeholder="Ingresá la cantidad de cuotas para los casos de financiación"
                name="cant_cuotas"
                value = "<?php echo $cant_cuotas; ?>"
                />
            </div>
            <div class="campo">
                <label for="porcentaje_quita">Porcentaje de quita</label>
                <input
                type="text"
                id="porcentaje_quita"
                placeholder="Ingresá el % para los casos de quita"
                name="porcentaje_quita"
                value = "<?php echo $porcentaje_quita; ?>"
                />
            </div>
            <input type="submit"  name="submit_siguiente" class="boton" value="Obtener resultados">
            <div class="contenedor">
                <br>
                <?php @include_once __DIR__ . '/../templates/alertas.php'?>
            </div>
        </form>
    </div>
    <!--Paso 2 -->
<?php if(!$datos_paso1) {?>
    <div class="contenedor">
        <p class="text-center">Ingresá los valores para ver las opciones de financiación y quita</p>
    </div>
<?php } else { ?>
    <div class="contenedor contenedor-datos-usuario">
        <div>
            <h3>Resultado para financiación</h3>
            <p><span>Honorarios: </span>$<?php echo number_format($honorarios, 2); ?></p>
            <p><span>Monto total: </span>$<?php echo number_format($monto_total, 2) ; ?></p>
            <p><span>Monto de la cuota: </span>$<?php echo number_format($monto_cuotas, 2); ?></p>
        </div>
        <div>
            <h3>Resultado para quita</h3>
            <p><span>Honorarios: </span>$<?php echo number_format($honorarios, 2); ?></p>
            <p><span>Monto de la quita: </span>$<?php echo number_format($monto_quita, 2); ?></p>
            <p><span>Monto total a pagar: </span>$<?php echo number_format($monto_total_a_pagar, 2); ?></p>
        </div>
    </div>
    <div class="contenedor">
        <form action="/nueva-gestion-operacion?id=<?php echo $id; ?>" class="formulario-ventana" method="POST">
            <div class="campo">
                <label for="accion">Cual fue la acción realizada?</label>
                <select name="accion" id="accion">
                    <option value=""> - Seleccionar -</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Entrante TP (Fijo)') echo 'selected'; ?>>Llamada Entrante TP (Fijo)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Saliente TP (Fijo)') echo 'selected'; ?>>Llamada Saliente TP (Fijo)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Entrante TP (Celular)') echo 'selected'; ?>>Llamada Entrante TP (Celular)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Saliente TP (Celular)') echo 'selected'; ?>>Llamada Saliente TP (Celular)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Entrante WP (Celular)') echo 'selected'; ?>>Llamada Entrante WP (Celular)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Llamada Saliente WP (Celular)') echo 'selected'; ?>>Llamada Saliente WP (Celular)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Chat WP (Celular)') echo 'selected'; ?>>Chat WP (Celular)</option>
                    <option <?php if(isset($_POST['accion']) && $_POST['accion'] === 'Mensaje SMS (Celular)') echo 'selected'; ?>>Mensaje SMS (Celular)</option>
                </select>               
            </div>
            <div class="campo">
                <label for="tipo_negociacion">Qué opción fue elegida?</label>
                <select name="tipo_negociacion" id="tipo_negociacion">
                    <option value=""> - Seleccionar -</option>
                    <option <?php if(isset($_POST['tipo_negociacion']) && $_POST['tipo_negociacion'] === 'Financiacion') echo 'selected'; ?>>Financiacion</option>
                    <option <?php if(isset($_POST['tipo_negociacion']) && $_POST['tipo_negociacion'] === 'Quita') echo 'selected'; ?>>Quita</option>
                </select>                
            </div>
            <div class="campo">
                <label for="resultado">Cual es el resultado?</label>
                <select name="resultado" id="resultado">
                    <option value=""> - Seleccionar -</option>
                    <option <?php if(isset($_POST['resultado']) && $_POST['resultado'] === 'Negociación') echo 'selected'; ?>>Negociación</option>
                    <option <?php if(isset($_POST['resultado']) && $_POST['resultado'] === 'Propuesta de Pago') echo 'selected'; ?>>Propuesta de Pago</option>
                </select>                
            </div>
            <div class="campo">
                <label for="observaciones">Observaciones</label>
                <input
                type="text"
                id="observaciones"
                placeholder="Observaciones"
                name="observaciones"
                value="<?php echo s($nuevaGestion->observaciones); ?>"
                maxlength="150"
                />
            </div>
            <input type="hidden" name="monto_negociado" value="<?php echo $monto_negociado; ?>">
            <input type="hidden" name="cant_cuotas" value="<?php echo $cant_cuotas; ?>">
            <input type="hidden" name="monto_cuotas" value="<?php echo $monto_cuotas; ?>">
            <input type="hidden" name="porcentaje_quita" value="<?php echo $porcentaje_quita; ?>">
            <input type="hidden" name="monto_quita" value="<?php echo $monto_quita; ?>">
            <input type="hidden" name="honorarios" value="<?php echo $honorarios; ?>">
            <input type="hidden" name="monto_total_a_pagar" value="<?php echo $monto_total_a_pagar; ?>">
            <input type="hidden" name="operacion_id" value="<?php echo $operacion->id; ?>">
            <input type="hidden" name="usuario_id" value="<?php echo $_SESSION['id']; ?>">
            <input type="submit" class="boton" name="submit_nueva_gestion" value="Nueva gestión">
        </form>
    </div>
    <?php } ?>
</div>



<?php @include_once __DIR__ . '/../templates/footer.php'?>