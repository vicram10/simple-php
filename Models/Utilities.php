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
        global $context;
        try
        {
            if (!@include_once($archivo))
            {
                throw new Exception("Error al leer el archivo, ". $archivo);
            }
        }
        catch(Exception $error)
        {

            $context['msgError'] = $error->getMessage();
        }
    }
    
    public function IncluirArchivoIdioma($archivo)
    {
        global $txt, $Configuraciones;
        try
        {
            if (!@include_once($Configuraciones->DirectorioTextos."/".$archivo.".".$Configuraciones->Idioma.".php"))
            {
                throw new Exception("Error al leer el archivo, ". $archivo);
            }
        }
        catch(Exception $error)
        {
            $context['msgError'] = $error->getMessage();
        }
    }

    public function IncluirView($view)
    {
        global $Configuraciones;
        require_once($Configuraciones->DirectorioVista."/".$view.".php");
    }

    public function Redireccionar($url)
    {
        global $Configuraciones;
        $redireccionar = !empty($url) ? $url : $Configuraciones->ScriptUrl;
        header('Location: '. $redireccionar);
    }

    public function EscapeString($string)
    {
        global $capaNegocios;
        return $capaNegocios->EscapeString($string);
    }

    // Construimos la Paginacion, es un poderoso constructor de paginas.. sacado de smf pero adaptado por mi 
    // :)
    // $pageindex = template_paginacion($scripturl, 'sub=id_seccion', $_REQUEST['start'], cantidad_registros_tabla, limite_maximo_a_mostrar, opcion_extra);
    function template_paginacion($base_url, $extra_parameter, &$start, $max_value, $num_per_page, $opcion_extra = '')
    {
        global $Configuraciones, $txt, $context;
        //Invalido comienzo?
        $start_invalid = $start < 0;    
        if ($start_invalid)
            $start = 0;
        elseif ($start >= $max_value)
            $start = max(0, (int) $max_value - (((int) $max_value % (int) $num_per_page) == 0 ? $num_per_page : ((int) $max_value % (int) $num_per_page)));
        else
            $start = max(0, (int) $start - ((int) $start % (int) $num_per_page));

        if(!empty($extra_parameter))
            $base_url = $base_url . '&amp;' . $extra_parameter . '&amp;';
        else
            $base_url = $base_url . '&amp;';
            
        $base_link = '<li class="page-item"><a class="page-link" href="' . (strtr($base_url, array('%' => '%%')) . 'pagina=%d') . '"'. ($opcion_extra) .'>%s</a></li> ';
        
        $pageindex = '<nav aria-label="Paginacion"><ul class="pagination">';
        // Mostramos la Flecha izquierda.
        $pageindex .= $start == 0 ? '<li class="page-item disabled"><span>'. $txt['paginacion_antes'] .'</span></li> ' : sprintf($base_link, $start - $num_per_page, $txt['paginacion_antes']);
        // Mostramos todas las paginas.
        $display_page = 1;
        for ($counter = 0; $counter < $max_value; $counter += $num_per_page)
            $pageindex .= $start == $counter && !$start_invalid ? '<li class="page-item active"><span class="page-link">' . $display_page++ . ' <span class="sr-only">(current)</span></span></li> ' : sprintf($base_link, $counter, $display_page++);
        // Mostramos la flecha Derecha
        $display_page = ($start + $num_per_page) > $max_value ? $max_value : ($start + $num_per_page);
        //if ($start != $counter - $max_value && !$start_invalid)
            $pageindex .= $display_page > $counter - $num_per_page ? '<li class="page-item disabled"><span class="page-link">'. $txt['paginacion_despues'] .'</span></li> ' : sprintf($base_link, $display_page, $txt['paginacion_despues']);
            
            $pageindex .= '</ul></nav>';
        //Ok, esta todo, ya tenemos nuestra paginacion preparada :P
        return $pageindex;
    }

    //nos permite cambiar a formato fecha
    public function FormatoFecha($tipo, $date)
    {
        $return = "";
       //decimos la regio de la fecha..
        setlocale(LC_ALL, 'es-ES'); 
        //devuelve 21/05/2012
        switch($tipo){
            case "blog":
                $return = strftime('%B %d, %Y',$date);
                break;
            case "mes_dia":
                $return = strftime('%B %d',$date);
                break;
            case "hora":
                $return = strftime('%H:%M',$date);      
                break;
            case "year":
                $return = strftime('%Y',$date);     
                break;  
            case "fecha_hora":
                $return = strftime('%d/%m/%y %H:%M', $date);
                break;
            case "fecha":
                $return = strftime('%d/%m/%Y',$date);
                break;
        }
        return $return;
    }
}
?>