<?php
	require_once DIR_GLOBAL_LIB . 'utilidades.php';	
	require_once DIR_CONFIG . 'bd.php';

	function ConectarBD ()
	{
		return GL_ConectarBD ( $GLOBALS['datos_bd'] );
	}


	// Lanza la consulta $consulta a la base de datos. 
	// Devueve el resultado en caso de éxito o finaliza la ejecución si
	// hubo algún error.
	function ConsultarBD( $consulta, $guardar_total = false )
	{
		return GL_ConsultarBD( $GLOBALS['datos_bd'], $consulta, $guardar_total );
	}


	function NotificarPorEmail( $tipo_notificacion, $id )
	{
		$bd = ConectarBD();
		switch( $tipo_notificacion ){
			case 'nueva_perla':
				$titulo = 'RAP - Nueva perla subida';
				$cuerpo = "Se ha subido una nueva perla a la RAP. Para verla pulsa en el siguiente enlace: \r\n";
				$cuerpo .= "http://www.neodivert.com/rap/general.php?seccion=mostrar_perla&perla=$id\r\n";

				$emails = $bd->query( "(SELECT DISTINCT email FROM usuarios JOIN notificaciones_email ON usuarios.id = notificaciones_email.usuario AND notificaciones_email.frecuencia='siempre' AND usuarios.cod_validacion_email IS NULL) UNION (SELECT DISTINCT email FROM usuarios JOIN notificaciones_email ON usuarios.id = notificaciones_email.usuario AND notificaciones_email.frecuencia='participante' AND usuarios.cod_validacion_email IS NULL JOIN participantes ON notificaciones_email.usuario = participantes.usuario WHERE participantes.perla=$id)" ) or die( $bd->error );
			break;
		}

		ini_set('sendmail_from', 'neodivert@gmail.com' );
		$bd->close();

		$destinatarios = '';
		while( $email = $emails->fetch_array() ){
			$destinatarios .= "{$email['email']}, ";
		}
		if( !mail( $destinatarios, $titulo, $cuerpo ) ){
			die( 'Error enviando las notificaciones' );
		}
	}

	function CrearCabeceraFormulario( $controlador, $method, $confirmacion = NULL ){
		echo "<form action=\"{$controlador}\" method=\"$method\" ";
		if( $confirmacion != NULL ){
			echo 'onsubmit="return confirm(\'Estas segur@?\')" ';
		}
		echo '>';
	}
?>