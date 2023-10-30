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

// Hapus aksescrud
if ($module=='aksescrud' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM aksescrud WHERE id_aksescrud='$_GET[id]'");
 		
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

// Input aksescrud
elseif ($module=='aksescrud' AND $act=='input'){

$bandingkan=mysql_query("select * from aksescrud where id_grupakses='$_POST[id_grupakses]' and id_modul='$_POST[id_modul]'");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan2 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=tambahaksescrud&err=ada');
	}
	else {
    logging($module,isi,'');

  mysql_query("INSERT INTO aksescrud(id_grupakses, id_modul, lihat, isi, ubah, hapus) VALUES('$_POST[id_grupakses]','$_POST[id_modul]','$_POST[lihat]','$_POST[isi]','$_POST[ubah]','$_POST[hapus]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahaksescrud&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahaksescrud&affect=tdk');
  		}  	
  }
}

// Update aksescrud
elseif ($module=='aksescrud' AND $act=='update'){

$bandingkan=mysql_query("select * from aksescrud where id_aksescrud!='$_POST[id]' and id_grupakses='$_POST[id_grupakses]' and id_modul='$_POST[id_modul]'");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan4 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=editaksescrud&id='.$_POST[id].'&err=ada');
	}
	else {
	
	logging($module,update,$_POST['id']);
    mysql_query("UPDATE aksescrud SET id_grupakses = '$_POST[id_grupakses]', id_modul='$_POST[id_modul]', lihat='$_POST[lihat]', isi='$_POST[isi]',ubah='$_POST[ubah]',hapus='$_POST[hapus]' WHERE id_aksescrud = '$_POST[id]'");
 	
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
