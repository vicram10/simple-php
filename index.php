<?php
//definimos una constante principal
define('eGeek', 1);
//Inicializamos el buffer de salida, tambien nos ayuda para redireccionar
ob_start();
//mostramos los errores de PHP
ini_set("error_reporting", E_ALL);
ini_set("display_errors", "On");
ini_set('memory_limit','-1');
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
    global $ClaseControlador, $Configuraciones, $Utilidades, $txt, $context, $objUsuario;
    //datos del usuario
    $objUsuario->getDatosUsuario();        
    //array principal
    $opt = !empty($_GET['opt']) ? $_GET['opt'] : 'Portal/Inicio';
    $optArray = explode('/', $opt);
    $context['Controller'] = ucfirst($optArray[0]);//capitaliza la primera letra de la palabra
    $context['ControllerAction'] = ucfirst($optArray[1]);
    //obtenemos el archivo del controller primeramente
    $Utilidades->IncluirArchivo($Configuraciones->DirectorioControlador."/Controller".$context['Controller'].".php");    
    //incluir el archivo de idioma del controlador actual
    $Utilidades->IncluirArchivoIdioma($context['Controller']);
    //continuamos y verificamos si existe la funcion en el controlador
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