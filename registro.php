<?php  
$con = mysqli_connect('localhost','root','','app_img');
?>
<html>
<body>
<div class="agregarNuevoUsuario">
   <h1>Bienvenido</h1>
      <link rel="stylesheet" type="text/css" href="estilos.css">
 <form method="post" action="registro.php">
         <input type="text" name="nombre" placeholder="Nombre" >
         <br><br>
         <input type="text" name="apellidos" placeholder="Apellidos" >
         <br><br>
         <input type="text" name="email" placeholder="Correo Electrónico" >
         <br><br>
         <input type="password" name="password" placeholder="Password">
         <br><br>
         <input type="submit" name="registro" value="Registro">

         <a href="index.php">  Inicia sesion </a>

   </form>


<?php 
if (isset($_POST['registro'])) {
   //CAPTURAR VARIABLES DEL POST
   $nombre = $_POST['nombre'];
   $apellidos = $_POST['apellidos'];
   $email = $_POST['email'];
   $password = $_POST['password'];
   $password = MD5($password);
  

   $insertarUsuario = "INSERT INTO usuario (nombre, apellidos, email, password) VALUES ('$nombre','$apellidos'
   ,'$email','$password')";
   mysqli_query($con, $insertarUsuario);
   echo "Te has Registrado correctamente!";
}

 ?>

</body>
</html> 
