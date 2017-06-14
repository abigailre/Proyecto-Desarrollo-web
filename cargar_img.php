<?php
session_start();
define ('SITE_ROOT', realpath(dirname(__FILE__))); 
include('db.php');
if(!isset($_SESSION['idUsuario'])){
	header('location:index.php');
}
$idUsuario = $_SESSION['idUsuario'];
$fecha = date('Y-m-d');
if (is_uploaded_file($_FILES['file']['tmp_name']))
{
 $nombreDirectorio = "img/";
 $nombreFichero = $_FILES['file']['name'];
 
$nombreCompleto = $nombreDirectorio . $nombreFichero;
 if (is_file($nombreCompleto))
 {
 $idUnico = rand(0,1000);
 $nombreFichero = $idUnico . "-" . $nombreFichero;
 }
 
move_uploaded_file($_FILES['file']['tmp_name'],SITE_ROOT.'/'.$nombreDirectorio.$nombreFichero);
$query  = "INSERT INTO img (idUsuario,img,fecha,estatus) VALUES (".$idUsuario.",'".$nombreDirectorio.$nombreFichero."','".$fecha."',1)";
$rQuery = consulta($query);
header('location:tl.php');
}
 
else{
 echo "No se ha podido subir el fichero";
}
