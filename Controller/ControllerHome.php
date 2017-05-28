<?php
if (!defined('eGeek'))
    die("Accion no Permitida, no se puede ingresar al archivo de forma directa");

//funcion inicio -> principal
function Index()
{
    global $txt, $context;
    $context['Titulo'] = 'Titulo';
    $context['View'] = 'Index';
}

?>