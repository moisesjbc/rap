<?php
	$mensajes = Array(
		'AV_PERLA_BORRADA'	=> 'La perla ha sido correctamente borrada',
		'AV_PERLA_DENUNCIADA'=> 'Tu voto para eliminar la perla se ha recibido correctamente',
		'AV_DENUNCIA_ELIMINADA' => 'Tu voto para eliminar la perla se ha eliminado correctamente'
	);

	echo "{$mensajes[$_GET['mensaje']]}<br/>";
?>
<a href="general.php?seccion=lista_perlas">Volver a la pagina principal</a>