<?php
class conection{
	
	public static function conectar(){

		$localhost = "localhost";
		$database = "dbintegrador";
		$user = "root";
		$password = "qwerty1234."; //Cambiar su contraseña

		$link = new PDO("mysql:host=$localhost;dbname=$database",$user,$password);

		return $link;
	}
}
?>
