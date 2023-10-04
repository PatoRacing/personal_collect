<?php
    foreach($alertas as $key=>$alerta): //Primero nos referimos al tipo de alerta. Luego pasamos el mensaje segun el tipo de alerta
        foreach($alerta as $mensaje):
?>

    <div class="alerta <?php echo $key; ?>"><?php echo $mensaje; ?></div>

<?php
        endforeach;
    endforeach;
?>