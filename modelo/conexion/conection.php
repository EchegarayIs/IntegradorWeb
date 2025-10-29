<?php
class conection{
	
	public static function conectar(){

		$localhost = "localhost";
		$database = "dbintegrador";
		$user = "root";
<<<<<<< HEAD
		$password = "qwerty1234."; //Cambiar su contraseña
=======
		$password = "123456"; //Cambiar su contraseña
>>>>>>> 97ea89d37e1c817448f42cf3e12e5d9082255f8f

		$link = new PDO("mysql:host=$localhost;dbname=$database",$user,$password);

		return $link;
	}
}
?>
