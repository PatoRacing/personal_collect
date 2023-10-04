<div class="barra-mobile">
    <h1>Personal Collect</h1>
    <div class="menu">
        <img id= "mobile-menu" src="build/img/menu.svg" alt="imagen menu">
    </div>
</div>

<div class="barra">
    <p>
        Hola: <span><?php echo $_SESSION['nombre']; ?></span>
        - Id: <span><?php echo $_SESSION['id']; ?></span>
    </p>
    <a href="/logout" class="cerrar-sesion">Cerrar Sesión</a>
</div>