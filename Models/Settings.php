<?php
/**
 clase principal de configuraciones
 */
class Configuraciones
{
    //constructor principal
    function __construct()
    {
        $this->TituloWeb = "MVCBase";
        $this->DirectorioPrincipal = "/var/www/html/MVCBase";
        $this->DirectorioVista = $this->DirectorioPrincipal."/View";
        $this->DirectorioControlador = $this->DirectorioPrincipal."/Controller";
        $this->DirectorioModelo = $this->DirectorioPrincipal."/Models";
        $this->DirectorioTextos = $this->DirectorioPrincipal."/Languages"; 
        $this->Idioma = "spanish";
        $this->PDOCadenaConexion = "mysql:host=localhost;dbname=invsyslite";
        $this->Usuario = "desarrollo";
        $this->Password = "aa.123456";
    }

    public function CargasIniciales()
    {
        global $Configuraciones, $Utilidades, $context;
        //incluimos el archivo de idioma
        $Utilidades->IncluirArchivoIdioma("Principal");
        $Utilidades->IncluirArchivoIdioma("Errors");
        $context['View']='';
        $context['Controller']='';
        $context['ControllerAction']='';
        $context['msgError']='';
    }
}

?>