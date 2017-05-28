<?php
if (!defined('eGeek'))
    die("Accion no Permitida, no se puede ingresar al archivo de forma directa");
/**
 tendra metodos que podemos usar en todo el proyecto
 */
class Utilidades
{
    public function __construct(){}
    public function EscribirArchivo($pathArchivo = "", $mensaje = "")
    {
        global $Configuraciones, $txt;
        if ($pathArchivo = fopen($pathArchivo, "a"))
        {
            if (fwrite($pathArchivo, "#". date("l d/F/Y H:i:s") ."\n".$mensaje."\n"))
            {

            }else{
                Print str_replace("<pathArchivo>", $pathArchivo, $txt["error_mod_archivo"]);
                exit;
            }
            fclose($pathArchivo);
        }else{
            Print str_replace("<pathArchivo>", $pathArchivo, $txt["error_abrir_archivo"]);;
            exit;
        }
    }

    public function IncluirArchivo($archivo)
    {
        require_once($archivo);
    }
    
    public function IncluirArchivoIdioma($archivo)
    {
        global $txt, $Configuraciones;
        require_once($Configuraciones->DirectorioTextos."/".$archivo.".".$Configuraciones->Idioma.".php");
    }

    public function IncluirView($view)
    {
        global $Configuraciones;
        require_once($Configuraciones->DirectorioVista."/".$view.".php");
    }
}
?>