<?php 
	include( 'classes/BD.class.php' ); // Clase de control de base de datos 
	include( 'classes/NewEmail.class.php' ); // Clase de control y chequeo de emails

	if( $_POST )
	{
		$data_base = new BD();
		if( $data_base )
		{
			$email = $_GET['email']; // Email ingresado desde el formulario de registro
			$new_email = new NewEmail( $email );
		} else {
			$error = "Hubo un problema con la base de datos, intente más tarde.";
		}
	}
	echo "hola";
?>