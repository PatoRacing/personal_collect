<div class="campo">
                <label for="nombre">Nombre</label>
                <input
                type="text"
                id="nombre"
                placeholder="Nombre del usuario"
                name="nombre"
                value="<?php echo s($usuario->nombre); ?>"
                />
            </div>

            <div class="campo">
                <label for="apellido">Apellido</label>
                <input
                type="text"
                id="apellido"
                placeholder="Apellido del usuario"
                name="apellido"
                value="<?php echo s($usuario->apellido); ?>"
                />
            </div>

            <div class="campo">
                <label for="dni">DNI</label>
                <input
                type="number"
                id="dni"
                placeholder="DNI del usuario"
                name="dni"
                value="<?php echo s(trim($usuario->dni)); ?>"
                />
            </div>

            <div class="campo">
                <label for="rol">Rol del usuario</label>
                <select name="roles_id" id="rol">
                <option selected value=""> - Seleccionar -</option>
                <?php foreach ($roles as $rol) { ?>
                <option
                <?php echo $usuario->roles_id === $rol->id ? 'selected' : '';?>
                value="<?php echo s($rol->id); ?>">
                <?php echo $rol->rol; ?>
                </option>
                <?php } ?>
                </select>                
            </div>

            <div class="campo">
                <label for="telefono">Telefono</label>
                <input
                type="number"
                id="telefono"
                placeholder="Ingresa el teléfono del usuario"
                name="telefono"
                value="<?php echo s($usuario->telefono); ?>"
                />
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                id="email"
                placeholder="Email del usuario"
                name="email"
                value="<?php echo s($usuario->email); ?>"
                />
            </div>

            <div class="campo">
                <label for="domicilio">Domicilio</label>
                <input
                type="text"
                id="domicilio"
                placeholder="Domicilio del usuario"
                name="domicilio"
                value="<?php echo s($usuario->domicilio); ?>"
                />
            </div>

            <div class="campo">
                <label for="localidad">Localidad</label>
                <input
                type="text"
                id="localidad"
                placeholder="Localidad del usuario"
                name="localidad"
                value="<?php echo s($usuario->localidad); ?>"
                />
            </div>

            <div class="campo">
                <label for="codigoPostal">Código Postal</label>
                <input
                type="number"
                id="codigoPostal"
                placeholder="Código postal del usuario"
                name="codigoPostal"
                value="<?php echo s($usuario->codigoPostal); ?>"
                />
            </div>

            <div class="campo">
                <label for="fechaIngreso">Fecha de Ingreso</label>
                <input
                type="date"
                id="fechaIngreso"
                placeholder="Fecha de ingreso del usuario"
                name="fechaIngreso"
                value="<?php echo s($usuario->fechaIngreso); ?>"
                />
            </div>

            
           

            
