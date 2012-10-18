<?php 
	/**
	* Obtengo la plantilla a utilizar para enviar correos dependiendo del estado de la suscripción
	*/
	class Mailer
	{		
		public $template = ''; //Plantilla que se va a usar para enviar el email, formato html por defecto
		public $from = '"Ana Frenkel"<info@anafrenkel.com.ar>';
		public $headers = array();
		/* Direccion web donde se encuentran alojados los archivos */
		public $siteName = 'http://www.anafrenkel.com.ar/boletin'; // No se olvide de agregar http:// o https://

		function __construct( $template_file )
		{
			$this->template = $this->siteName . '/admin/templates/' . $template_file . '.html';			
		}		

		public function enviar_email( $email, $id_email, $string, $mensaje='', $imagen1=NULL )
		{
			$this->headers = "From:".$this->from."\nReply-To:".$this->su_email."\n"; 
			$this->headers = $this->headers ."X-Mailer:PHP/".phpversion()."\n"; 
			$this->headers = $this->headers ."Mime-Version: 1.0\n"; 
			$this->headers = $this->headers ."Content-Type: text/html"; 

			$email_body = file_get_contents( $this->template );

			$email_body = strtr($email_body, array(
					'{$imagen1}' => $imagen1,
					'{$mensaje}' => $mensaje,
					'{$id}' => $id_email,
					'{$siteName}' => $this->siteName
					));

			if( mail( $email, $string, $email_body, $this->headers ) )
			{
				return true;
			} else {
				return false;
			}
		}       
	}
?>