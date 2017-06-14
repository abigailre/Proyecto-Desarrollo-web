<?php 

function conexion(){
	$con = mysqli_connect('localhost','root','','app_img');
	return $con;
}

function consulta($query){
	$con = conexion();
	$res = mysqli_query($con, $query);
	mysqli_close($con);
	return $res; 
	
}
