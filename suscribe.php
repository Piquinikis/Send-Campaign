<?php 
	include( 'classes/BD.class.php' ); // Clase de control de base de datos 
	include( 'classes/Mailer.class.php' ); // Clase de control y chequeo de emails

	if( $_POST )
	{
		$data_base = new BD();
		if( $data_base )
		{
			$email = $_POST['email'];
			/* Expresion regular para verificar que el email sea correcto, esto si el navegador no soporta html5 */
			if( !preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $email) ) 
			{
				$error = "El email no es v&aacute;lido, intente nuevamente.";
			} else {
				/* Guardo el registro en la base de datos, si no se puede muestro el error */
				/* Primero busco si existe duplicados, retorna TRUE si no existe el registro */
				if( $data_base->buscar_duplicado( $email ) )
				{
					if( $id_conexion = $data_base->agregar_registro( $email ) )
					{

					// Llamo a la instancia de la clase para que envie el correo con la confirmación de la suscripcion
						$enviar_suscripcion = new Mailer( "confirmacion" ); // Arma el template
						$enviar_suscripcion->enviar_email( $email, $id_conexion, "Confirme su suscripci&oacute;n" ); //Envia el correo

						$success = "Revise su casilla de email para confirmar su suscripci&oacute;n.";
					} else {
						echo $conecto;
						$error = "Hubo un error al guardar su email, intente de nuevo.";
					}
				} else { $error = "Su email ya se encuentra registrado a nuestro newsletter."; }			
			}	
		} else {
			$error = "Hubo un problema con la base de datos, intente m&aacute;s tarde.";
		}

		$data_base->database_close();
	}

?>