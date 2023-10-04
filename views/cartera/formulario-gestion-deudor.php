
<div class="campo">
    <label for="deudor_id">Deudor</label>
    <input
    type="text"
    id="deudor_id"
    placeholder="Nombre del deudor"
    name="deudor_id"
    value="<?php echo s($deudor->nombre); ?>"
    readonly
    />
</div>

<div class="campo">
    <label for="usuario_id">Usuario</label>
    <input
    type="text"
    id="usuario_id"
    placeholder="Nombre del usuario"
    name="usuario_id"
    value="<?php 
        if($usuarioId) {
            echo $_SESSION['nombre'] . " " . $_SESSION['apellido'];
        }?>"
    readonly
    >
</div>

<div class="campo">
    <label for="accion">Accion realizada</label>
    <select name="accion" id="accion">
    <option selected value=""> - Seleccionar -</option>
    <option>Llamada Entrante TP (Fijo)</option>
    <option>Llamada Saliente TP (Fijo)</option>
    <option>Llamada Entrante TP (Celular)</option>
    <option>Llamada Saliente TP (Celular)</option>
    <option>Llamada Entrante WP (Celular)</option>
    <option>Llamada Saliente WP (Celular)</option>
    <option>Chat WP (Celular)</option>
    <option>Mensaje SMS (Celular)</option>
    </select>                
</div>

<div class="campo">
    <label for="resultado">Resultado / Situación</label>
    <select name="resultado" id="resultado">
    <option selected value=""> - Seleccionar -</option>
    <option> En proceso</option>
    <option> Fallecido</option>
    <option> Ubicado</option>
    </select>                
</div>

<div class="campo">
    <label for="campaña_mail">Deseas activar una campaña de mail?</label>
    <select name="campaña_mail" id="campaña_mail">
    <option selected value=""> - Seleccionar -</option>
    <option> Si</option>
    <option> No</option>
    </select> 
</div>

<div class="campo">
    <label for="observaciones">Obser-<br>vaciones</label>
    <input
    type="text"
    id="observaciones"
    placeholder="Observaciones"
    name="observaciones"
    value="<?php echo s($gestionDeudor->observaciones); ?>"
    maxlength="150"
    />
</div>







            
           

            
