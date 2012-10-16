<?php 
	/**
	* Controlar la Base de Datos desde esta clase para mantener la seguridad
	* function agregar_registro, lo almacena provisoriamente hasta que el usuario confirma la suscripción
	* function update_registro( @param $id ), cambia el estado del registro a permanente y queda suscripto
	*/
	class BD
	{
		private $conexion;
		private $root = 'localhost';
		private $user_name = 'root';
		private $database_password = '';

		function __construct()
		{
			if( $this->connect_database() ) { return false; } else { return false; }
		}

		private function connect_database()
		{
			if( $this->conexion = mysql_connect( $this->root, $this->user_name, $this->database_password ) )
			{
				mysql_select_db( "newsletter", $this->conexion );
				return true;
			} else { 
				return false; 
			}
		}

	/**
	* Almaceno el registro pero aún no lo activo porque el usuario no confirmo su suscripción
	*/
		public function agregar_registro( $email )
		{
			$sql = "INSERT INTO `mails` (email, status, created) VALUES ('". $email ."', 'inactive', '". strtotime(date('Y-m-d')) ."')";			
			if( mysql_query( $sql, $this->conexion ) ) { 
				$id_email = mysql_query("SELECT `id_email` FROM `mails` WHERE `email`='". $email ."'", $this->conexion );
				return $id_email; 
			} else { return mysql_error($this->conexion); } //Si no se guarda el registro devuelve falso
		}

		public function update_registro( $id )
		{
			$sql = "UPDATE `mails` SET `status`='active'";
			if( mysql_query( $sql, $this->conexion ) ) { return true; } else { return false; } //Si no se guarda el registro devuelve falso
		}

		public function buscar_duplicado( $email )
		{
			$buscar = "SELECT `email` FROM `mails` WHERE `email`='". $email ."'";
		// Si no hay duplicados retorno TRUE
			if( !mysql_query( $buscar, $this->conexion ) ) { return true; } else { return false; }				
		}

		public function database_close()
		{
			mysql_close( $this->conexion );
		}
	}
?>