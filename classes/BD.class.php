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

		public function update_registro( $id, $status='active' )
		{
			$sql = "UPDATE `mails` SET `status`='". $status ."'";
			if( mysql_query( $sql, $this->conexion ) ) { return true; } else { return false; } //Si no se guarda el registro devuelve falso
		}

	/**
	* Debe devolver TRUE en el caso de no encontrar concordancias o bien FALSE 
	* si el email ya esta en la base de datos 
	*/
		public function buscar_duplicado( $email )
		{
			$buscar = "SELECT * FROM `mails` WHERE `email`='". $email ."'";
			$result = mysql_query( $buscar, $this->conexion );
		// Si no hay duplicados retorno TRUE
			if( $fila = mysql_fetch_array( $result ) ) 
			{ 			
				return true; 
			} elseif( $fila['email'] == $email ) {
				$this->update_registro( $fila['id_email'] ); // Vuelvo a activar el email para los boletines
				return false; //Aviso de que el email ya esta registrado
			} else {
				/** 
				* En el caso de que el email nunca estubo registrado en el boletin 
				*/
					return false; 
			}		
		}

		public function devolver_email( $id )
		{
			$sql = "SELECT `email` FROM `mails` WHERE `id_email`='". $id ."'";
			$consulta = mysql_query( $sql, $this->conexion );
			$email = mysql_result( $consulta, 0 );
			return $email;
		}

		public function listar_campaings()
		{
			$listado = array();
			$sql = "SELECT * FROM `campaings`";
			if( $result = mysql_query( $sql, $this->conexion ) )
			{
				$listado = mysql_result( $result );
			}
			return $listado;
		}

		public function listar_correos()
		{
			$listado = array();
			$sql = "SELECT * FROM `emails`";
			if( $result = mysql_query( $sql, $this->conexion ) )
			{
				$listado = mysql_result( $result );
			}
			return $listado;
		}

	// Cierro la conexion con la base de datos
		public function database_close()
		{
			mysql_close( $this->conexion );
		}
	}
?>