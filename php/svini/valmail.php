<?php
	function generarLinkTemporal($idusuario){

		$cadena = $idusuario.rand(1,9999999).date('Y-m-d');
		$token = sha1($cadena);
		
		include('../lib/conexion.php');
    $mysql = new conexion();
    $con=$mysql->get_connection();

		$sql = "INSERT INTO sv11res (sv07cdtp,sv11tok,sv11fchs) VALUES ('$idusuario','$token',NOW());";

		$resultado = $con->query($sql);
		if($resultado){
			$enlace = 'https://www.santacruz.go.cr/sicovip/Restablecer.php?idusuario='.sha1($idusuario).'&token='.$token;
			return $enlace;
		}
		else
			return FALSE;
	}

	function enviarEmail( $email, $link ){
		$msg = null;
		$nombre=null;

		$asunto="Restablecer contraseña";
		$mensaje = '<html>
		<head>
 			<title>Restablece tu contraseña</title>
		</head>
		<body>
 			<p>Hemos recibido una petición para restablecer la contraseña de tu cuenta.</p>
 			<p>Si hiciste esta petición, haz clic en el siguiente enlace, si no hiciste esta petición puedes ignorar este correo.</p>
 			<p>
 				<strong>Enlace para restablecer tu contraseña</strong><br>
 				<a href="'.$link.'"> Restablecer contraseña </a>
 			</p>
		</body>
		</html>';

		 require "phpmailer/class.phpmailer.php";
        include ("../lib/conf.php");
    
          $mail = new PHPMailer;
		  
		  //indico a la clase que use SMTP
          $mail->IsSMTP();
		  
          //permite modo debug para ver mensajes de las cosas que van ocurriendo
          //$mail->SMTPDebug = 2;

		  //Debo de hacer autenticación SMTP
          $mail->SMTPAuth = true;
          $mail->SMTPSecure = "ssl";

		  //indico el servidor de Gmail para SMTP
          $mail->Host = "smtp.gmail.com";

		  //indico el puerto que usa Gmail
          $mail->Port = 465;

		  //indico un usuario / clave de un usuario de gmail

        $mail->Username = MAIL;
        $mail->Password = PASS;
       
          $mail->From = "tuemail@gmail.com";
        
          $mail->FromName = "Municipalidad de Santa Cruz";
        
          $mail->Subject = $asunto;
        
          $mail->addAddress($email, $nombre);
        
          $mail->MsgHTML($mensaje);  
        
          if($mail->Send())
        {
    $msg= "En hora buena el mensaje ha sido enviado con exito a $email";
    }
        else
        {
    $msg = "Lo siento, ha habido un error al enviar el mensaje a $email";
    }
	}
include('php/lib/conexion.php');
$mysql = new conexion();
      $con=$mysql->get_connection();

	$email = mysqli_real_escape_string($con,$_POST['email']);
	//$respuesta = new stdClass();

	if( $email != "" ){   
   		   		$sql = " SELECT sv07cdtp, sv07emt FROM sv07tpgfo WHERE sv07emt = '$email' ";
   		$resultado = $con->query($sql);

   		if($resultado->num_rows > 0){
      		$usuario = $resultado->fetch_assoc();
			$linkTemporal = generarLinkTemporal( $usuario['sv07cdtp']);
      		if($linkTemporal){
        		enviarEmail( $email, $linkTemporal );
        		header("location:../../mjsSi.html");
        		
      		}
   		}else{
   			$stm=" SELECT sv01cdtc, sv01emc FROM sv01clnte WHERE sv01emc = '$email' ";
   			$res=$con->query($stm);
   			if ($res->num_rows > 0) {
   				$use= $res->fetch_assoc();
   				$linkTemporal= generarLinkTemporal($use['sv01cdtc']);
   				if ($linkTemporal) {
   					enviarEmail($email,$linkTemporal);
   					header("location:../../mjsSi.html");
   				}
   			}else{
   			header("location:../../mjsNo.html");
   		}

   		}
   	}
	else{
   		$respuesta->mensaje= "Debes introducir el email de la cuenta";
	}
 	