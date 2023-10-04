<div class="campo">
                <label for="nombre">Nombre</label>
                <input
                type="text"
                id="nombre"
                placeholder="Nombre del Cliente"
                name="nombre"
                value="<?php echo s($cliente->nombre); ?>"
                />
            </div>

            <div class="campo">
                <label for="domicilio">Domicilio</label>
                <input
                type="text"
                id="domicilio"
                placeholder="Calle y número"
                name="domicilio"
                value="<?php echo s($cliente->domicilio); ?>"
                />
            </div>

            <div class="campo">
                <label for="codigoPostal">Código Postal</label>
                <input
                type="number"
                id="codigoPostal"
                placeholder="Código Postal"
                name="codigoPostal"
                value="<?php echo s($cliente->codigoPostal); ?>"
                />
            </div>

            <div class="campo">
                <label for="localidad">Localidad</label>
                <input
                type="text"
                id="localidad"
                placeholder="Localidad"
                name="localidad"
                value="<?php echo s($cliente->localidad); ?>"
                />                
            </div>

            <div class="campo">
                <label for="provincia">Provincia</label>
                <input
                type="text"
                id="provincia"
                placeholder="Provincia"
                name="provincia"
                value="<?php echo s($cliente->provincia); ?>"
                />
            </div>

            <div class="campo">
                <label for="contacto">Contacto</label>
                <input
                type="text"
                id="contacto"
                placeholder="Contacto"
                name="contacto"
                value="<?php echo s($cliente->contacto); ?>"
                />
            </div>

            <div class="campo">
                <label for="telefono">Teléfono</label>
                <input
                type="number"
                id="telefono"
                placeholder="Número de contacto"
                name="telefono"
                value="<?php echo s($cliente->telefono); ?>"
                />
            </div>

            <div class="campo">
                <label for="email">Email</label>
                <input
                type="email"
                id="email"
                placeholder="Correo electrónico"
                name="email"
                value="<?php echo s($cliente->email); ?>"
                />
            </div>

            <div class="campo">
                <label for="usuarios_id">Usuario</label>
                <input
                type="text"
                id="usuarios_id"
                placeholder="Usuario creador"
                name="usuarios_id"
                value="<?php 
                if($usuarioId) {
                    echo $_SESSION['nombre'] . " " . $_SESSION['apellido'];
                }
                 ?>"
                 readonly 
                />
            </div>

            

            
           

            
