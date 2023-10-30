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

// Hapus kategorinilai
if ($module=='kategorinilai' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM kategorinilai WHERE id_kategorinilai='$_GET[id]'");
 		
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

// Input kategorinilai
elseif ($module=='kategorinilai' AND $act=='input'){

$bandingkan=mysql_query("select * from kategorinilai where kategorinilai='$_POST[kategorinilai]' ");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan2 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=tambahkategorinilai&err=ada');
	}
	else {
    logging($module,isi,'');

  mysql_query("INSERT INTO kategorinilai(kategorinilai,persentasenilai,nilaimaksimal) VALUES('$_POST[kategorinilai]','$_POST[persentasenilai]','$_POST[nilaimaksimal]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahkategorinilai&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahkategorinilai&affect=tdk');
  		}  	
  }
}

// Update kategorinilai
elseif ($module=='kategorinilai' AND $act=='update'){
	
$bandingkan3=mysql_query("select * from kategorinilai where id_kategorinilai!='$_POST[id]' and kategorinilai='$_POST[kategorinilai]'");
$bandingkan4=mysql_num_rows($bandingkan3);

	if ($bandingkan4 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=editkategorinilai&id='.$_POST[id].'&err=ada');
	}
	else {	
	  logging($module,update,$_POST['id']);

    mysql_query("UPDATE kategorinilai SET kategorinilai = '$_POST[kategorinilai]',persentasenilai='$_POST[persentasenilai]', nilaimaksimal='$_POST[nilaimaksimal]' WHERE id_kategorinilai = '$_POST[id]'");
 	
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
