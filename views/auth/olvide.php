<div class="contenedor auth">
    
    <?php @include_once __DIR__ . '/../templates/nombre-sitio.php'?>

    <div class="contenedor-sm">
        <p class="descripcion-pagina">Recupera tu acceso a la plataforma</p>

        <?php @include_once __DIR__ . '/../templates/alertas.php'?>
        <form class="formulario" method="POST" action="/olvide">

            <div class="campo">
                <label for="mail">Email</label>
                <input
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                />
            </div>
           <input type="submit" class="boton" value="Enviar instrucciones">
        </form>
        <div class="acciones">
            <a href="/">Ya tienes cuenta? Inicia sesión</a>
        </div>
    </div>
</div>