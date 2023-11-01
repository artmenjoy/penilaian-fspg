<?php
session_start();
 if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";
include "../../config/fungsi_log.php";

$act=$_GET['act'];
$id=$_GET['id_peserta'];

//buat agar bisa edit

// buat allow delete
if ($act=='allow'){
	
  mysql_query("UPDATE peserta SET `bisahapus` = 1 WHERE id_peserta=$id");	
 		
  		if(mysql_affected_rows() > 0){  		
  		header('location:../../media.php?module=rekapnilai&act=lihatpeserta&id=8&affect=yes');
		}
		else{
			header('location:../../media.php?module=rekapnilai&act=lihatpeserta&id=8&affect=no');
		}
  
		
} 
elseif ($act=='disallow') {
	mysql_query("UPDATE peserta SET `bisahapus` = 0 WHERE id_peserta=$id");	
 		
	if(mysql_affected_rows() > 0){  		
	header('location:../../media.php?module=rekapnilai&act=lihatpeserta&id=8&affect=yes');
	}
else{
	header('location:../../media.php?module=rekapnilai&act=lihatpeserta&id=8&affect=no');
	}
}

}
?>