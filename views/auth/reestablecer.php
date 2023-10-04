<div class="contenedor auth">
    
    <?php @include_once __DIR__ . '/../templates/nombre-sitio.php'?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Coloca tu nuevo password</p>

        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <?php if($error) return; ?>
        <form class="formulario" method="POST" >

            <div class="campo">
                <label for="password">Password</label>
                <input
                type="password"
                id="password3"
                placeholder="Tu Password"
                name="password"
                oninput="mostrarCaracteres3(this)"
                />
            </div>
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>

        
        <div class="acciones">
            <a href="/">Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</div>

<script src="build/js/mostrar-password3.js"></script>;