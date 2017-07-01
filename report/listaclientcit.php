<?php 
  require_once("dompdf/dompdf_config.inc.php");
include("../php/lib/conexion.php");
$mysql = new conexion();
      $con=$mysql->get_connection();
$id=$_GET['S'];
$codigoHTML='
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Reporte</title>
</head>

<body>
<div align="left">
  <img src="img/sc.jpg" width="100px" height="100px">
   <p><h5>Municipalidad Santa Cruz</h5></p>
  <p><h5>Departamento Catastro y Topografia</h5></p>
</div>
  <br>
  <br>
    <table align="center" width="98%" border="1">
      <tr>
        <td bgcolor="#0099FF"><strong>Cedula</strong></td>
        <td bgcolor="#0099FF"><strong>Nombre</strong></td>
        <td bgcolor="#0099FF"><strong>N Finca</strong></td>
        <td bgcolor="#0099FF"><strong>Solicitud</strong></td>
        <td bgcolor="#0099FF"><strong>Visado</strong></td>
        <td bgcolor="#0099FF"><strong>Estado</strong></td>
    </tr>';

        $consulta="SELECT DISTINCT a.sv03cedp,a.sv03nomp,a.sv03apdp,b.sv04nfin,c.sv08fchs,t.sv09fvdp,s.sv02dete,d.sv01cedc,d.sv01cdtpc

                                    FROM  sv03ptario a, sv04reqtos b, sv08trmte c, sv01clnte d, sv09vsdo t, sv02estdo s
                                     
                                WHERE c.sv04nfin= t.sv04nfin 
                                AND a.sv03cedp = t.sv03cedp
                                AND b.sv04nfin = t.sv04nfin
                                AND t.sv01cedc = d.sv01cedc
                                AND c.sv02code = s.sv02code                                
                                AND d.sv01cdtpc='$id'";
         $query=$con->query($consulta);
 if ($query->num_rows>0) {
   while ($dato=$query->fetch_array()){
$codigoHTML.='
      <tr>
        <td>'.$dato['sv03cedp'].'</td>
        <td>'.$dato['sv03nomp'].'&nbsp;'.$dato['sv03apdp'].'</td>
        <td>'.$dato['sv04nfin'].'</td>
        <td>'.$dato['sv08fchs'].'</td>
        <td>'.$dato['sv09fvdp'].'</td>
        <td>'.$dato['sv02dete'].'</td>
        </tr>';
      } 
$codigoHTML.='
    </table>
  
</div>
</body>
</html>';

$codigoHTML=utf8_decode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream("ReporteClienteCIT.pdf");
 }else{
  print "<script>alert(\"No se pudo consultar.\");</script>";
 }
// <td>'. if($dato["sv02code"]==5){echo 'Aprobado';}elseif($dato["sv02code"]==6){echo 'Rechazado';}else{echo 'En proceso';}.'</td>
?>

