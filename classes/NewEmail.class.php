<?php 
	/**
	* Obtengo la plantilla a utilizar para enviar correos dependiendo del estado de la suscripción
	*/
	$template = '';
	$su_email = 'danielrussian@gmail.com';
	$headers = array();
	$subject; 
	$siteName = ''; // No se olvide de agregar http:// o https://

	class NewEmail
	{		
		function __construct( $template_file, $string )
		{
			$this->template = 'admin/template/' . $template_file . '.html';
			
		}		

		public function enviar_email( $email, $id_email, $string )
		{
			$para = $email;
			$this->subject = $string;
			$this->headers = array(
				"MIME-Version: 1.0\r\n", 
				"Content-type: text/html; charset=utf-8", 
				"From: $this->su_email\r\n" . "Reply-To: $this->su_email \r\n" . "X-Mailer: PHP/"
				);
			$email_body = file_get_contents( $this->template );

			$email_body = strtr($email_body,array(
					'{$id}' => $id_email,
					'{$siteName}' => $this->siteName
					);

			mail( $this->su_email, $subject, $email_body, $headers );
		}
        
	}
?>