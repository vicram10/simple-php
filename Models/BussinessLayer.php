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

    //contador de tablas
    public function ContadorRegitrosTabla($tabla, $condicional)
    {
        global $conexion, $Utilidades, $Configuraciones;
        $resultado = array();
        try
        {
            $string = "SELECT * FROM ".$tabla." ".$condicional;
            $sql = $conexion->prepare($string);
            $sql->execute();
            $resultado = $sql->rowCount();
        }
        catch(PDOException $PDOError)
        {
            $msgError = "SQL ".$string."\nMensaje Error: ".$PDOError->getMessage();
            $Utilidades->EscribirArchivo($Configuraciones->DirectorioPrincipal."/ErrorLogBussinessLayer.txt", 
                $msgError);
        }
        return (int) $resultado;
    }

    public function InsertarRegistros($nombreTabla, $parametros = array())
    {
        global $conexion, $Utilidades, $Configuraciones, $capaNegocios;
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
                    $Datos = "(". ($valores['tipo'] == "string" ? $capaNegocios->EscapeString($valores['dato']) : $valores['dato']); 
                }else{
                    $Cols = $Cols .", ".$columnas;
                    //$Datos = $Datos. ", ". ($valores['tipo'] == "string" ? "'". $valores['dato'] ."'" : $valores['dato']);
                    $Datos = $Datos. ", ". ($valores['tipo'] == "string" ? $capaNegocios->EscapeString($valores['dato']) : $valores['dato']);
                }
            }
            $comando = $comando . " ". $Cols .") values ". $Datos . ")";
            $sql = $conexion->prepare($comando);
            $sql->execute();
            $msgError="";
        }
        catch(PDOException $PDOError)
        {
            $msgError = 'Error al querer Insertar Registros en la tabla '.strtoupper($nombreTabla) .'\nMensaje Error: '.$PDOError->getMessage() . '\nComando SQL: '. $comando;
            $Utilidades->EscribirArchivo($Configuraciones->DirectorioPrincipal."/ErrorLogBussinessLayer.txt", 
                $msgError);
            $msgError = str_replace('\n', '<br />', $msgError);
        }
        return $msgError;
    }

    public function ActualizarRegistros($condicional, $nombreTabla, $parametros = array())
    {
        global $conexion, $Utilidades, $Configuraciones, $capaNegocios;
        try
        {
            $comando = "UPDATE ".$nombreTabla;
            $valoresCampos = "";
            $valorCondicional = "";
            //datos
            foreach($parametros as $columnas => $valores)
            {
                if (empty($valoresCampos))
                {
                    $valoresCampos = "SET ".$columnas;
                    $valoresCampos = $valoresCampos . " = ". ($valores['tipo'] == "string" ? $capaNegocios->EscapeString($valores['dato']) : $valores['dato']); 
                }else{
                    $valoresCampos = $valoresCampos . ", ". $columnas;
                    $valoresCampos = $valoresCampos . " = ". ($valores['tipo'] == "string" ? $capaNegocios->EscapeString($valores['dato']) : $valores['dato']); 
                }
            }
            if (count($condicional) > 0)
            {
                foreach($condicional as $columna => $valores)
                {
                    if (empty($valorCondicional))
                    {
                        $valorCondicional = "WHERE ". $columna . " ". $valores['condicion'] . " ". $valores['dato'];
                    }else{
                        $valorCondicional = $valorCondicional ." ". $columna . " ". $valores['condicion'] . " ". $valores['dato'];
                    }
                }
            }
            $comando = $comando . " ". $valoresCampos . " ". $valorCondicional;
            $sql = $conexion->prepare($comando);
            $sql->execute();
            $msgError="";
        }
        catch(PDOException $PDOError)
        {
            $msgError = 'Error al querer Insertar Registros en la tabla '.strtoupper($nombreTabla) .'\nMensaje Error: '.$PDOError->getMessage() . '\nComando SQL: '. $comando;
            $Utilidades->EscribirArchivo($Configuraciones->DirectorioPrincipal."/ErrorLogBussinessLayer.txt", 
                $msgError);
            $msgError = str_replace('\n', '<br />', $msgError);
        }
        return $msgError;
    }

    //devolvemos un array con los datos que queremos
    public function DevuelveVector($string, $parametros = array())
    {
        global $conexion;
        $resultado = array();
        $sql = $conexion->prepare($string, array(PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY));
        if (count($parametros)>0)
        {
            $sql->execute($parametros);
            $resultado = $sql->fetchAll();
        }else{
            $sql->execute();
            $resultado = $sql->fetchAll();
        }
        $sql->closeCursor();
        return $resultado;
    }

    public function EscapeString($string)
    {
        global $conexion;
        return $conexion->quote($string);
    }
}
?>