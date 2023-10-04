<aside class="sidebar">
    <div class="contenedor-sidebar">
        <h2>Personal <br> Collect</h2>
        <h3>Personal Collect</h3>
        <div class="cerrar-menu">
            <img id= "cerrar-menu" src="build/img/cerrar.svg" alt="imagen cerrar menu">
        </div>
    </div>
    
    <nav class="sidebar-nav">
        <a class="<?php echo ($titulo === 'Agenda') ? 'activo' : ""; ?>" href="/agenda">
        <i class="fa-solid fa-calendar-days sidebar-icono"></i>
            <span class="dashboard__menu-texto">
                Agenda
            </span>
        </a>
        <a class="<?php echo
            (
            $titulo === 'Usuarios' ||
            $titulo === 'Crear Usuario' ||
            $titulo === 'Editar Usuario' ||
            $titulo === 'Perfil del Usuario'
            )
            ? 'activo' : ""; ?>" href="/usuarios">
            <i class="fa-solid fa-users sidebar-icono"></i>
                <span class="dashboard__menu-texto">
                    Usuarios
                </span>
        </a>
        <a class="<?php echo
            (
            $titulo === 'Clientes' ||
            $titulo === 'Crear cliente' ||
            $titulo === 'Editar cliente' ||
            $titulo === 'Perfil del cliente'||
            $titulo === 'Importar cartera de cliente'
            )
            ? 'activo' : ""; ?>" href="/clientes">
            <i class="fa-solid fa-building-columns sidebar-icono"></i>
                <span class="dashboard__menu-texto">
                    Clientes
                </span>
        </a>
        <a class="<?php echo
            (
            $titulo === 'Cartera'||
            $titulo === 'Actualizar Deudor'||
            $titulo === 'Perfil del Deudor'||
            $titulo === 'Gestión sobre operación'||
            $titulo === 'Nueva Gestión sobre la operación'||
            $titulo === 'Gestión sobre deudor'
            )
            ? 'activo' : ""; ?>" href="/cartera">
            <i class="fa-solid fa-credit-card sidebar-icono"></i>
                <span class="dashboard__menu-texto">
                    Cartera
                </span>
        </a>
        <a class="<?php echo
            (
            $titulo === 'Propuestas de Pago'
            )
            ? 'activo' : ""; ?>" href="/propuestas">
            <i class="fa-solid fa-file-circle-check sidebar-icono"></i>
                <span class="dashboard__menu-texto">
                    Propuestas
                </span>
        </a>
    </nav>
    
    <div class="cerrar-sesion-mobile">
        <a href="/logout" class="cerrar-sesion">Cerrar Sesion</a>
    </div>
    
</aside>