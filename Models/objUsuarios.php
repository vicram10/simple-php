<?php
/*
clase usuarios 
*/
class Usuario
{
	
	function __construct(){}

	//para controlar el login del usuario
	function loginUsuario($usuario, $password)
	{
		global $capaNegocios, $context, $txt, $sc;
		$resulado = false;
		$row = $capaNegocios->DevuelveVector("select c.*, cc.departamento from usuarios c, departamentos cc where c.user_key = :usuario  and c.user_pass = :password and c.user_depart = cc.cod_depart", 
			array(':usuario' => $usuario, ':password' => sha1(md5($password))));
		//solo si nos trae algo hacemos esta parte
		$entro = false;
		if (count($row))
		{
			foreach($row as $fila)
			{
				$entro = true;
				$_SESSION[$sc.'_codigoUsuario'] = (int)$fila['user_cod'];
				$_SESSION[$sc.'_estaConectado'] = true;
				$_SESSION[$sc.'_nombreUsuario'] = trim($fila['user_name']);
				$_SESSION[$sc.'_usuario'] = $usuario;
				$_SESSION[$sc.'_id_depart'] = $fila['user_depart'];
				$_SESSION[$sc.'_depart'] = $fila['departamento'];
				$_SESSION[$sc.'_locked'] = $fila['estado'] == 'BLOQUEADO' ? 1 : 0;
			}
		}
		if ($entro)
		{
			$resulado = true;
		}else{
			$mensaje = $txt['login_error'];
			$context['msgError'] = $mensaje;	
		}
		return $resulado;
	}

	//obtiene los datos del usuario logueado
	function getDatosUsuario()
	{
		global $datosUsuario, $user_key, $sc, $txt;
		//session del usuario
		//Iniciamos la Session
		session_start();
		//Seleccionamos un codigo generado
		if (!isset($_SESSION['session_value']))
		{
			$_SESSION['session_value'] = md5(session_id() . time() . mt_rand());
			$_SESSION['estaConectado'] = false;
		}
		$sc = $_SESSION['session_value'];
		//usuario
		$user_key = !empty($_SESSION[$sc.'_usuario']) ? strtoupper($_SESSION[$sc.'_usuario']) : '';
		//codigo de usuario
		$user_cod = !empty($_SESSION[$sc.'_codigoUsuario']) ? $_SESSION[$sc.'_codigoUsuario'] : 0;
		//variable global para el usuario
		$datosUsuario = array();
		//cargamos nuestra variable principal 
		$datosUsuario += array(
			'codigo' => !empty($_SESSION[$sc.'_codigoUsuario']) ? $_SESSION[$sc.'_codigoUsuario'] : 0,
			'usuario' => $user_key,
			'conectado' => !empty($_SESSION[$sc.'_estaConectado']) ? $_SESSION[$sc.'_estaConectado'] : false,
			'nombreUsuario' => !empty($_SESSION[$sc.'_nombreUsuario']) ? $_SESSION[$sc.'_nombreUsuario'] : $txt['label_invitado'],
			'id_depart' => !empty($_SESSION[$sc.'_id_depart']) ? $_SESSION[$sc.'_id_depart'] : 0,
			'depart' => !empty($_SESSION[$sc.'_depart']) ? $_SESSION[$sc.'_depart'] : '',
			'locked' => !empty($_SESSION[$sc.'_locked']) ? $_SESSION[$sc.'_locked'] : 0,
			'es_admin' =>  (!empty($_SESSION[$sc.'_id_depart']) && $_SESSION[$sc.'_id_depart']==1) ? 1 : 0,
		);
	}

	//destruimos la sesion y cerramos todo
	function CerrarSesion()
	{
		//destruimos la sesion
		session_destroy();
	}

	//para saber si que permisos tiene el usuario que se loguea
	function PermisosMenu($menu)
	{
		global $capaNegocios, $datosUsuario, $user_key;
		
		//el administrador puede ver todo
		if ($datosUsuario['es_admin'] == 1)
		{
			return true;
		}else{
			$idDepart = (int) $datosUsuario['id_depart'];
			//verificamos si tiene los permisos necesarios
			$tienePermiso = $capaNegocios->ContadorRegitrosTabla('menu_acceso', "where codMenu = '$menu' and user_depart = $idDepart");
			if ($tienePermiso > 0)
				return true;
			else
				return false;
		}
	}
}

?>