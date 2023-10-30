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

// Hapus userkategorinilai
if ($module=='userkategorinilai' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM userkategorinilai WHERE id_userkategorinilai='$_GET[id]'");
 		
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

// Input userkategorinilai
elseif ($module=='userkategorinilai' AND $act=='input'){

$bandingkan=mysql_query("select * from userkategorinilai where id_kategorinilai='$_POST[id_kategorinilai]' and id_user='$_POST[id_user]'");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan2 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=tambahuserkategorinilai&err=ada');
	}
	else {
    logging($module,isi,'');

  mysql_query("INSERT INTO userkategorinilai(id_user, id_kategorinilai) VALUES('$_POST[id_user]','$_POST[id_kategorinilai]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahuserkategorinilai&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahuserkategorinilai&affect=tdk');
  		}  	
  }
}

// Update userkategorinilai
elseif ($module=='userkategorinilai' AND $act=='update'){
	
$bandingkan3=mysql_query("select * from userkategorinilai where id_userkategorinilai!='$_POST[id]' and id_user='$_POST[id_user]' and id_kategorinilai='$_POST[id_kategorinilai]'");
$bandingkan4=mysql_num_rows($bandingkan3);

	if ($bandingkan4 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=edituserkategorinilai&id='.$_POST[id].'&err=ada');
	}
	else {	
	  logging($module,update,$_POST['id']);

    mysql_query("UPDATE userkategorinilai SET id_user = '$_POST[id_user]',id_kategorinilai='$_POST[id_kategorinilai]' WHERE id_userkategorinilai = '$_POST[id]'");
 	
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
