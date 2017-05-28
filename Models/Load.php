<?php
if (!defined('eGeek'))
    die("Accion no Permitida, no se puede ingresar al archivo de forma directa");
/**
Archivo principal que contendra metodos que se usaran en todo el proyecto.
*/
class Load
{    
    //constructor
    public function __construct(){}
    //metodo que nos permite inicializar y mostrar la web
    public function MostrarWeb()
    {
        global $Configuraciones, $txt, $context, $Utilidades;
        //obtenemos la vista a ser mostrada
        $Utilidades->IncluirView('Header');
        if (!empty($context['msgError']))
            $Utilidades->IncluirView('Error');
        else
            $Utilidades->IncluirView($context['Controller']."/".$context['View']);
        $Utilidades->IncluirView('Footer');
    }
}

?>