<!--
/**
 * Incluye y muestra el resultado del método estático "ver" de la clase "login".
 *
 * Este fragmento de código PHP incluye el archivo "clase.php", que contiene la definición
 * de la clase "login". Luego, llama al método estático "ver" de la clase "login" mediante
 * la sintaxis de PHP echo(), que muestra el resultado devuelto por dicho método en esta sección
 * del código HTML.
 * 
 * @version 1.0
 * @author Pablo Alexander Mondragon Acevedo
 *         Keiner Yamith Tarache Parra
 */
-->
<div class="row">
    <?php
    include("../model/clase.php");
    echo(login::ver());
    ?>
</div>