<?php
//definimos una constante principal
define('eGeek', 1);
//mostramos los errores de PHP
ini_set("error_reporting", E_ALL);
ini_set("display_errors", "On");
ini_set('memory_limit',128);
//fin mostramos los errores de php
require_once("Models/Settings.php");
require_once("Models/Utilities.php");
require_once("Models/BussinessLayer.php");
require_once("Models/Load.php");
$txt = array();
$context = array();
$Configuraciones = new Configuraciones;
$capaNegocios = new BussinessLayer;
$Utilidades = new Utilidades;
$Load = new Load();
$capaNegocios->AbrirConexion();
$Configuraciones->CargasIniciales();   
//inicializamos los valores principales para luego mostrar los resultados 
call_user_func('InicializacionWeb');  
//funcion principal
$Load->MostrarWeb();

//para inicializacion de la web  
function InicializacionWeb()
{
    global $ClaseControlador, $Configuraciones, $Utilidades, $txt, $context;        
    //array principal
    $opt = !empty($_GET['opt']) ? $_GET['opt'] : 'Home/Index';
    $optArray = explode('/', $opt);
    $context['Controller'] = $optArray[0];
    $context['ControllerAction'] = $optArray[1];
    //obtenemos el archivo del controller primeramente
    $Utilidades->IncluirArchivo($Configuraciones->DirectorioControlador."/Controller".$context['Controller'].".php");    
    if (function_exists($optArray[1]))
    {
        $optArray[1]();
    }else{
        $mensaje = $txt['error_no_controller_action'];
        $mensaje = str_replace('<Controller>', $context['Controller'], $mensaje);
        $mensaje = str_replace('<ControlerAction>', $context['ControllerAction'], $mensaje);
        $context['msgError'] = $mensaje;
    }
}
?>