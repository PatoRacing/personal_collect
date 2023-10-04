<?php @include_once __DIR__ . '/../templates/header.php'?>

<div class="contenedor-boton-agregar-usuario">
    <a class="boton" href="/usuarios">
    <i class="fa-solid fa-circle-arrow-left"></i>
        Volver
    </a>
</div>

<div class="contenedor-perfil-usuario">
    <h3>Datos Personales</h3>
    <div class="contenedor contenedor-datos-usuario">
    <div>
        <p><span>ID: </span> <?php echo $usuario->id; ?></p>
        <p><span>Nombre: </span><?php echo $usuario->nombre . " " . $usuario->apellido; ?></p>
        <p><span>DNI: </span> <?php echo $usuario->dni; ?></p>
        <p><span>Fecha de ingreso: </span> <?php echo $fechaFormateada; ?></p>
    </div>

    <div>        
        <p><span>Teléfono: </span> <?php echo $usuario->telefono; ?></p>
        <p><span>Email: </span> <?php echo $usuario->email; ?></p>
        <p><span>Domicilio: </span> <?php echo $usuario->domicilio; ?></p>
        
    </div>

    <div>
        <p><span>Localidad: </span><?php echo $usuario->localidad; ?></p>
        <p><span>Código Postal: </span> <?php echo $usuario->codigoPostal; ?></p>
        <p><span>Rol: </span>
            <?php foreach ($roles as $rol) { ?>
            <?php if($usuario->roles_id === $rol->id) {?>
            <?php echo $rol->rol; }?>
            <?php }?>  
    </div>
    </div>
</div>

<div class="contenedor-perfil-usuario">
    <h3>Gestiones realizadas</h3>
    <div class="contenedor contenedor-datos-usuario">
    
    </div>
</div>
<?php @include_once __DIR__ . '/../templates/footer.php'?>
