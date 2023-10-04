
<div class="campo">
    <label for="nombre">Nombre</label>
    <input
    type="text"
    id="nombre"
    placeholder="Nombre del deudor"
    name="nombre"
    value="<?php echo s($deudor->nombre); ?>"
    />
</div>

<div class="campo">
    <label for="tipo_doc">Tipo DNI</label>
    <input
    type="text"
    id="tipo_doc"
    placeholder="Tipo DNI"
    name="tipo_doc"
    value="<?php echo s($deudor->tipo_doc); ?>"
    />
</div>

<div class="campo">
    <label for="nro_doc">DNI</label>
    <input
    type="number"
    id="nro_doc"
    placeholder="DNI del usuario"
    name="nro_doc"
    value="<?php echo s(trim($deudor->nro_doc)); ?>"
    />
</div>

<div class="campo">
    <label for="domicilio">Domicilio</label>
    <input
    type="text"
    id="domicilio"
    placeholder="Domicilio"
    name="domicilio"
    value="<?php echo s(trim($deudor->domicilio)); ?>"
    />        
</div>

<div class="campo">
    <label for="localidad">Localidad</label>
    <input
    type="text"
    id="localidad"
    placeholder="Localidad"
    name="localidad"
    value="<?php echo s(trim($deudor->localidad)); ?>"
    />        
</div>

<div class="campo">
    <label for="codigo_postal">Codigo Postal</label>
    <input
    type="text"
    id="codigo_postal"
    placeholder="Codigo Postal"
    name="codigo_postal"
    value="<?php echo s(trim($deudor->codigo_postal)); ?>"
    />        
</div>

<div class="campo">
    <label for="telefono">Telefono</label>
    <input
    type="number"
    id="telefono"
    placeholder="Teléfono del deudor"
    name="telefono"
    value="<?php echo s($deudor->telefono); ?>"
    />
</div>

<div class="campo">
    <label for="email">Email</label>
    <input
    type="email"
    id="email"
    placeholder="Email del deudor"
    name="email"
    value="<?php echo s($deudor->email); ?>"
    />
</div>

            
           

            
