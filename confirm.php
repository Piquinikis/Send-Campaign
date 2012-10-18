<?php 
	include( 'classes/BD.class.php' );
	include( 'classes/Mailer.class.php' );

	if( $id_email = $_GET['id'] )
	{
		$base_datos = new BD();

		if( $base_datos->update_registro( $id_email) )
		{
			$email = $base_datos->devolver_email( $id_email );

			$confrimar_suscripcion = new Mailer( "bienvenido" ); //instancio la clase con el nombre de la plantilla html
			$confrimar_suscripcion->enviar_email( $email, $id_email, "Bienvenido a nuestro newsletter" );

			echo 'Bienvenido a nuestro boletin.';
		}

		$base_datos->database_close();
	}
?>