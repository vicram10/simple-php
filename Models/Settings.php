<?php
/**
 clase principal de configuraciones
 */
class Configuraciones
{
    //constructor principal
    function __construct()
    {
        $this->TituloWeb = "MVC.PHP";
        $this->UrlPrincipal = "http://invsyslitemvcphp";
        $this->ScriptUrl = $this->UrlPrincipal.'/index.php';
        $this->DirectorioPrincipal = "G:\\Proyectos\\Sistemas\\04-GitHub\\InvSysLiteMVCphp";
        $this->DirectorioVista = $this->DirectorioPrincipal."/View";
        $this->UrlTheme = $this->UrlPrincipal.'/View/Themes/Default';
        $this->DirectorioControlador = $this->DirectorioPrincipal."/Controller";
        $this->DirectorioModelo = $this->DirectorioPrincipal."/Models";
        $this->DirectorioTextos = $this->DirectorioPrincipal."/Languages"; 
        $this->Idioma = "spanish";
        $this->PDOCadenaConexion = "mysql:host=localhost;dbname=invsyslite";
        $this->Usuario = "desarrollo";
        $this->Password = "a.123456";
        $this->UrlAmigable = false;
        $this->UrlAmigableExtension = '/';//solo puede ser tipo carpeta "/" o ".html"
        $this->LimitePaginacion = 10;
    }

    public function CargasIniciales()
    {
        global $Configuraciones, $Utilidades, $context, $objUsuario, $Load, $objTemplate;
        //incluimos el archivo de idioma
        $Utilidades->IncluirArchivoIdioma("Principal");
        $Utilidades->IncluirArchivoIdioma("Errors");
        //incluir archivos importantes
        $Utilidades->IncluirArchivo($Configuraciones->DirectorioModelo."/objUsuarios.php");
        $Utilidades->IncluirArchivo($Configuraciones->DirectorioModelo."/Templates.php");
        $context['Titulo'] = '';
        $context['DescripcionTitulo'] = '';
        $context['View'] = '';
        $context['Controller']='';
        $context['ControllerAction']='';
        $context['msgError']='';
        $context['version'] = '1.0.0-30092017.2300';
        $context['meta_descripcion'] = '';
        $context['html_header'] = '';
        $context['html_footer'] = '';
        $context['debug'] = true;
        //los objetos
        $objUsuario = new Usuario();
        $objTemplate = new Templates();
    }
}

?>