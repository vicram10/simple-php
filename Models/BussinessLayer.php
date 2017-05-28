<?php
if (!defined('eGeek'))
    die("Accion no Permitida, no se puede ingresar al archivo de forma directa");
/**
Para poder realizar las conexiones a la base de datos
**/
class BussinessLayer extends PDO
{
    public function __construct(){}
    public function AbrirConexion()
    {
        global $Configuraciones, $conexion;
        try
        {
            $conexion = new PDO($Configuraciones->PDOCadenaConexion,
                $Configuraciones->Usuario, 
                $Configuraciones->Password);
            //para poder mostrar los errores
            $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $PDOError)
        {
            echo "ERROR: " . $PDOError->getMessage();
            exit;
        }        
    }

    //para poder ejecutar sin necesidad de devolver un valor
    public function Ejecutar($string, $parametros = array())
    {
        global $conexion, $Utilidades, $Configuraciones;
        try
        {
            $sql = $conexion->prepare($string);
            $sql->execute();
        }
        catch(PDOException $PDOError)
        {
            $msgError = "SQL ".$string."\nMensaje Error: ".$PDOError->getMessage();
            $Utilidades->EscribirArchivo($Configuraciones->DirectorioPrincipal."/ErrorLogBussinessLayer.txt", 
                $msgError);
        }
    }

    public function InsertarRegistros($nombreTabla, $parametros = array())
    {
        global $conexion, $Utilidades, $Configuraciones;
        try
        {
            $comando = "insert into ".$nombreTabla;
            $Cols = "";
            $Datos = "";
            //datos
            foreach($parametros as $columnas => $valores)
            {
                if (empty($Cols))
                {
                    $Cols = "(".$columnas;
                    $Datos = "(". ($valores['tipo'] == "string" ? "'". $valores['dato'] ."'" : $valores['dato']); 
                }else{
                    $Cols = $Cols .", ".$columnas;
                    $Datos = $Datos. ", ". ($valores['tipo'] == "string" ? "'". $valores['dato'] ."'" : $valores['dato']);
                }
            }
            $comando = $comando . " ". $Cols .") values ". $Datos . ")";
            $sql = $conexion->prepare($comando);
            $sql->execute();
        }
        catch(PDOException $PDOError)
        {
            $msgError = "Error al querer Insertar Registros en la tabla ".strtoupper($nombreTabla) ."\nMensaje Error: ".$PDOError->getMessage();
            $Utilidades->EscribirArchivo($Configuraciones->DirectorioPrincipal."/ErrorLogBussinessLayer.txt", 
                $msgError);
        }
    }

    //devolvemos un array con los datos que queremos
    public function DevuelveVector($string, $parametros = array())
    {
        global $conexion;
        $sql = $conexion->prepare($string);
        if (count($parametros)>0)
        {
            $sql->execute($parametros);
            $resultado = $sql->fetchAll();
        }else{
            $sql->execute();
            $resultado = $sql->fetchAll();
        }
        return $resultado;
    }
}
?>