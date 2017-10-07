<?php
//empezamos con el codigo
global $Configuraciones, $Load, $txt, $context;

//si estamos en modo debug vamos a habilitar algunas cosas
if ($context['debug'])
{
    echo '<br /><br />
    <div class="note note-success">
        ', $txt['debug_title'] ,'
    </div>';
    $Load->ModoDebug();
}
//DESDE AQUI LA PROGRAMACION
echo 'Footer';
?>