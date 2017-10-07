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
        global $Load, $Configuraciones, $txt, $context, $Utilidades;
        //menu principal solo los habilitado = 'SI'
        $Load->MenuPrincipal('SI');
        //es json lo que queremos mostrar?
        if ($context['View'] != 'json')
        {
            //obtenemos la vista a ser mostrada
            $Utilidades->IncluirView('Header');
            if (!empty($context['msgError']))
                $Utilidades->IncluirView('Error');
            else
                $Utilidades->IncluirView($context['Controller']."/".$context['View']);
            $Utilidades->IncluirView('Footer');
        }else{
            $Utilidades->IncluirView('json');
        }
    }

    public function ModoDebug()
    {
        global $datosUsuario, $context, $txt;
        echo '<div class="note note-warning">$datosUsuario</div>';
        var_dump($datosUsuario);
        echo '<div class="note note-warning">$context</div>';
        var_dump($context);
        echo '<div class="note note-warning">$txt</div>';
        var_dump($txt);
    }
}

?>