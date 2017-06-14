<?php 
session_start();
include('db.php');

$email = $_POST['email'];
$password = $_POST['password'];
$query  = "SELECT * FROM usuario where email like '".$email."'";
$rQuery = consulta($query);
if(mysqli_num_rows($rQuery) == 1){
	while($r = mysqli_fetch_array($rQuery)){
		if ($r['password'] == MD5($password)) {
			$_SESSION['idUsuario'] = $r['idUsuario'];
			header('location:tl.php');
		} else {
			echo 'El password es incorrecto.';
		}
	}
} else {
	echo 'El usuario no existe.';
}
