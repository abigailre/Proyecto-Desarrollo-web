<?php 
session_start();
include('db.php');
$conexion = conexion ();
if(!isset($_SESSION['idUsuario'])){
	header('location:index.php');
}

$idUsuario = $_SESSION['idUsuario'];
$query  = "SELECT * FROM usuario where idUsuario = ".$idUsuario;
$usuarioQuery = consulta($query);
$queryComentario = "SELECT * FROM comentario";
$comentarios = consulta($queryComentario);


$queryImg  = "SELECT * FROM img where estatus = 1 and idUsuario = ".$idUsuario;
$imgQuery = consulta($queryImg);
?>
<!DOCTYPE html>
<html>
<head>
	<title>App Img</title>
	<link rel="stylesheet" type="text/css" href="estilos.css">

</head >
<body>
	
	<table>
		<?php 
		while($rUsu = mysqli_fetch_array($usuarioQuery)):
			?>
		<tr>
			<td align="left"><?php echo $rUsu['nombre'].' '.$rUsu['apellidos']?></td>
			<td align="left">APP IMG</td>
			<td align="right">
			<a href="cerrar_sesion.php"> Finalizar sesión</a>
			</td>
		</tr>
		</table>
		<?php 
		endwhile;
		?>
		
		<br><br>
		 <div class= "busqueda">
 	<h2>Buscar</h2>
 		<form method="POST" action="tl.php">
	 		<input type="search" name="busqueda" placeholder="Buscar ...">
	 		<input type="submit" name="buscar" value="Buscar">

 		</form>

 </div>
<div class="busqueda">
 	<h2>Resultados de busqueda</h2>

 	<?php
 	if (isset($_POST['busqueda'])) {
 	 	//SE BUSCA TODO, SIN CRITERIO DE BUSQUEDA
 	 	$buscarTodo = "SELECT * FROM usuario WHERE nombre LIKE '%".$_POST['busqueda']."%'";
 	 	$resultadosTodos = consulta($buscarTodo);
 	 	//IMPRIMIMOS LOS RESULTADOS EN LA TABLA
 	 	echo "<table>";
 	 	while ($r = mysqli_fetch_array($resultadosTodos)) {
 	 		echo "<tr>";
 	 		echo "<td>".$r['nombre']."</td>";
 	 		echo "<td>".$r['apellidos']."</td>";
 	 		echo "<td>".$r['email']."</td>";
 	 		echo "<td>".$r['estatus']."</td>";
 	 		
 	 	}
 	 	
 	 }
 	?>
 	
 </div>
 <br><br>

 
	<table style="width:40%; margin:auto;">

		<?php 
		$conImg = null;
		while($rImg = mysqli_fetch_array($imgQuery)):
			$conImg = $rImg;

			?>

		<tr>

			<td align="left">
				<img src="<?php echo $rImg['img']; ?>" alt="" style="width:100%;">
				<?php echo $rUsu['nombre'].' '.$rUsu['apellidos']?>

				

				<?php
				$comen = "SELECT texto
				FROM comentario
				WHERE comentario.idImagen = " . $rImg['idImagen'] . "
				ORDER BY idImagen DESC;";	
				
	$resultado = consulta($comen);



echo "<table border='1' align='center'>";
echo "<tr bgcolor='#CCCCCC'>";
echo "<td><b>Comentarios:</b></td>";
echo "</tr>";
	if ($resultado) {

while ($row = mysqli_fetch_array($resultado)){
    echo "<tr>";
    echo "<td>".$row["texto"]."</td>";
    echo "</tr>";
}}
	

echo "</table>";
				?>

			<form  action="tl.php" method="POST">
	 		<textarea id="coment" name="Comentario" value="<?php echo $conImg['idImagen']?>";></textarea> 
	 		<input id="EnviarComent" type="submit" name="comentario" value="comentario"/>
 			</form>
			
			</td>
			
		<?php
		endwhile;
		?>

	</table>
	<br><br><br>
	<aside>	

	<?php
				 
 if(isset($_POST['Comentario'])){
	
 	
			$comentar = "INSERT INTO comentario(idUsuario, texto, idImagen) VALUES(".$_SESSION['idUsuario'].", '" . $_POST['Comentario'] . "', '". $conImg['idImagen'] ."');";
			$conexion ->query($comentar);
		}	        
?>
	<?php

  if (isset($_POST['idImageLike'])) {
    $queryDarLike = "INSERT INTO gusta (idUsuario, idImagen) VALUES({$_SESSION['id']}, {$_POST['idImageLike']});";
    if ($conexion->query($queryDarLike)) {
      echo "Ok";
    }
  }
  if (isset($_POST['idImagen'])) {
    $queryQuitarLike = "DELETE FROM gusta WHERE idImagen = {$_POST['idImageDislike']} AND idUsuario = {$_SESSION['id']}";
    
  }

 ?>


</aside>

 <form action="cargar_img.php" method="post" enctype="multipart/form-data">
		<input type="file" name="file">
		<input type="submit" value="subir foto">
	</form>
 </body>
</html>
