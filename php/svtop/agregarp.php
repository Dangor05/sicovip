<?php

if(!empty($_POST)){
	if (isset($_POST['svcedp']) && isset($_POST['svnomp']) && isset($_POST['svapdp']) && isset($_POST['svemp']) && isset($_POST['svtelp']) && $_POST['svcodp']) 
	{
		//
				include "../lib/conexion.php";
				$mysql = new conexion();
			$con=$mysql->get_connection();
			
$sv03cedp=$_POST['svcedp'];  
$sv03nomp=$_POST['svnomp'];  
$sv03apdp=$_POST['svapdp'];  
$sv03emp=$_POST['svemp'];   
$sv03telp=$_POST['svtelp'];
$sv06codp = $_POST['svcodp']; 
			
			$sql = "INSERT INTO sv03ptario (sv03cedp,sv03nomp,sv03apdp,sv03emp,sv03telp,sv06codp) values 
                   ('$sv03cedp','$sv03nomp','$sv03apdp','$sv03emp','$sv03telp','$sv06codp')";



			$query = $con->query($sql);
			if($query!=null){
				mysqli_close($con);
				$dir ="../../archivos/".$sv03cedp."/ ";
		mkdir($dir,7055);
				print "<script>alert(\"Agregado exitosamente.\");window.location='../../PropietarioMostrar.php';</script>";
			}else{
				mysqli_close($con);
				print "<script>alert(\"Algo a sucedido, Verifica los datos e intenta más tarde.\");window.location='../../PropietarioMostrar.php';</script>";

			}
	}

	}	
?>