<?php 
	/**
	* 
	*/
	class BD
	{
		private $root = 'localhost';
		private $user_name = 'root';
		private $database_password = '';

		function __construct()
		{
			if( $this->connect_database() ) { return true; } else { return false; }
		}

		private function connect_database()
		{
			if( mysql_connect( $this->root, $this->user_name, $this->database_password ) or die('Error conectando con la base de datos') )
			{
				return true;
			} else { 
				return false; 
			}
		}

		public function agregar_registro()
		{

		}

		public function update_registro()
		{

		}

	}
?>