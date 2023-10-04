<div class="contenedor auth">
<?php @include_once __DIR__ . '/../templates/nombre-sitio.php'?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Iniciar Sesión</p>
        
        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <form class="formulario" method="POST" action="/">
            <div class="campo">
                <label for="mail">Email</label>
                <input
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                />
            </div>
            <div class="campo">
                <label for="password">Password</label>
                <input
                type="password"
                id="password"
                placeholder="Tu Password"
                name="password"
                oninput="mostrarCaracteres(this)"
                />
            </div>
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <div class="acciones">
            <a href="/olvide">Olvidaste tu password? Click aquí</a>
        </div>
    </div>
</div>

<script src="build/js/mostrar-password.js"></script>;
