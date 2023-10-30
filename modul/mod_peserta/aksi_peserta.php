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

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus peserta
if ($module=='peserta' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM peserta WHERE id_peserta='$_GET[id]'");
 		
 		if(mysql_errno()==1451){ //dependensi dengan field lain (restrict)
			header('location:../../media.php?module='.$module.'&err=sql');
		}
		
		else if(mysql_affected_rows() > 0){  		
  			
  		header('location:../../media.php?module='.$module.'&affect=ya2');
  	}
  	else{  		
  			
  		header('location:../../media.php?module='.$module.'&affect=tdk2');
  	}
  }
		
}

// Input peserta
elseif ($module=='peserta' AND $act=='input'){

$bandingkan=mysql_query("select * from peserta where peserta='$_POST[peserta]' ");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan2 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=tambahpeserta&err=ada');
	}
	else {
    logging($module,isi,'');

  mysql_query("INSERT INTO peserta(peserta,jemaat,id_rayon,kelamin) VALUES('$_POST[peserta]','$_POST[jemaat]','$_POST[id_rayon]','$_POST[kelamin]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahpeserta&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahpeserta&affect=tdk');
  		}  	
  }
}

// Update peserta
elseif ($module=='peserta' AND $act=='update'){
	
$bandingkan3=mysql_query("select * from peserta where id_peserta!='$_POST[id]' and peserta='$_POST[peserta]'");
$bandingkan4=mysql_num_rows($bandingkan3);

	if ($bandingkan4 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=editpeserta&id='.$_POST[id].'&err=ada');
	}
	else {	
	  logging($module,update,$_POST['id']);

    mysql_query("UPDATE peserta SET peserta = '$_POST[peserta]', jemaat='$_POST[jemaat]',id_rayon='$_POST[id_rayon]', nomortalent='$_POST[nomortalent]', kelamin='$_POST[kelamin]' WHERE id_peserta = '$_POST[id]'");
 	
 		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&affect=tdk');
  		}
}
}
}
?>
