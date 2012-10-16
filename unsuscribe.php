<?php
	include( 'classes/BD.class.php' );
	include( 'classes/Mailer.class.php' );

	if( $id_email = $_GET['id'] )
	{
		$id_email = filter_var( $id_email, FILTER_VALIDATE_INT ); // Valido que sea realmente un entero
		$base_datos = new BD();
		if( $base_datos->update_registro( $id_email, 'inactive' ) )
		{
			echo 'Su email ah sido eliminado de nuestro boletin.';
		}
	}
?>