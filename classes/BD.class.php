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
		private $nombre_basededatos = '';
		private $user_name = '';
		private $database_password = '';

		function __construct()
		{
			if( $this->connect_database() ) { return false; } else { return false; }
		}

		private function connect_database()
		{
			if( $this->conexion = mysql_connect( $this->root, $this->user_name, $this->database_password ) )
			{
				mysql_select_db( $this->nombre_basededatos, $this->conexion );
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
			if( mysql_query( $sql, $this->conexion ) ) 
			{ 				
				return true; 
			} else { return false; } //Si no se guarda el registro devuelve falso
		}

		public function update_registro( $id, $status='active' )
		{		
			$sql = "UPDATE `mails` SET `status`='". $status ."' WHERE `id_mail`='". $id ."'";
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
			if( mysql_num_rows( $result ) == 0 ) 
			{ 			
				return true; 
			} else {
				$fila = mysql_fetch_array($result);				
				$this->update_registro( $fila['id_mail'] ); // Vuelvo a activar el email para los boletines
				return false; //Aviso de que el email ya esta registrado
			}		
		}

		public function devolver_email( $id )
		{
			$sql = "SELECT `email` FROM `mails` WHERE `id_mail`='". $id ."'";
			$consulta = mysql_query( $sql, $this->conexion );
			$email = mysql_result( $consulta, 0 );
			return $email;
		}

		public function devolver_id( $email )
		{
			$result = mysql_query("SELECT `id_mail` FROM `mails` WHERE `email`='". $email ."'", $this->conexion );
			$id_email = mysql_result( $result, 0 );
			return $id_email;
		}	

		public function listar_campaigns()
		{
			$listado = array();
			$sql = "SELECT * FROM `campaigns` ORDER BY `fecha` DESC";
			if( $result = mysql_query( $sql, $this->conexion ) )
			{
				$i=0;
				while( $row = mysql_fetch_array( $result ))
				{
					$listado[$i]['id_campaign'] = $row['id_campaign'];
					$listado[$i]['fecha'] = $row['fecha'];
					$listado[$i]['enviados'] = $row['enviados'];
					$listado[$i]['rebotados'] = $row['rebotados'];
					$i = $i+1;
				}			
			}
			return $listado;
		}

		public function listar_correos()
		{
			$listado = array();
			$sql = "SELECT * FROM `mails` WHERE `status`='active'";
			if( $result = mysql_query( $sql, $this->conexion ) )
			{
				$i=0;
				while( $row = mysql_fetch_array( $result ))
				{
					$listado[$i]['id_mail'] = $row['email'];		
					$listado[$i]['email'] = $row['email'];	
					$i = $i+1;
				}	
			}
			return $listado;
		}

		public function guardar_campaigns( $entregados, $rebotados, $imagen )
		{
			$sql = "INSERT INTO `campaigns` ( fecha, enviados, rebotados, imagen ) VALUES ( '". strtotime(date('Y-m-d')) ."', '". $entregados ."', '". $rebotados ."', '". $imagen ."')";
			mysql_query( $sql, $this->conexion );
		}

	// Cierro la conexion con la base de datos
		public function database_close()
		{
			mysql_close( $this->conexion );
		}
	}
?>