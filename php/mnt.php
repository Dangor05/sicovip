<?php 
//$root = 'C:\xampp\htdocs\pruebas\funciona16\Sicovip\archivos/'.$_GET['id'].'/';
$root="../archivos/".$_GET['id']."/";
$file =$_GET['mnt'];
$path = $root.$file;
    header("Content-type: application/octet-stream");
    header("Content-Disposition: attachment; filename=$file");
    readfile($path);
?>