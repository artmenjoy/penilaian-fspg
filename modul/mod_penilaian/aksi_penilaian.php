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

// Hapus penilaian
if ($module=='penilaian' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM penilaian WHERE id_penilaian='$_GET[id]'");
 		
 		if(mysql_errno()==1451){ //dependensi dengan field lain (restrict)
			header('location:../../media.php?module='.$module.'&act=peserta&affect=tdk&id_kategorinilai='.$_GET[id_kategorinilai].'');
		}
		
		else if(mysql_affected_rows() > 0){  		
  			
  		header('location:../../media.php?module='.$module.'&act=peserta&affect=ya&id_kategorinilai='.$_GET[id_kategorinilai].'');
  	}
  	else{  		
  			
  		header('location:../../media.php?module='.$module.'&act=peserta&affect=tdk&id_kategorinilai='.$_GET[id_kategorinilai].'');
  	}
  }
		
}

// Input penilaian
elseif ($module=='penilaian' AND $act=='input'){

$bandingkan=mysql_query("select * from penilaian where id_kategorinilai='$_POST[id_kategorinilai]' and id_peserta='$_POST[id_peserta]' and id_user='$_SESSION[namauser]'");
$bandingkan2=mysql_num_rows($bandingkan);

	if ($bandingkan2 > 0){
  
  		header('location:../../media.php?module='.$module.'&act=tambahpenilaian&err=ada');
	}
	else {
    logging($module,isi,'');

//echo"INSERT INTO penilaian(penilaian,id_kategorinilai,id_peserta, id_user) VALUES('$_POST[penilaian]','$_POST[id_kategorinilai]','$_POST[id_peserta]','$_SESSION[namauser]')";
  $penilaianall=($_POST['content']+$_POST['correlation']+$_POST['performance'])/3;
  $catnilai="Penilaian A $_POST[content] <br> Penilaian B $_POST[correlation] <br> Penilaian C $_POST[performance]";
  mysql_query("INSERT INTO penilaian(penilaian,id_kategorinilai,id_peserta, id_user,catatan) VALUES('$penilaianall','$_POST[id_kategorinilai]','$_POST[id_peserta]','$_SESSION[namauser]','$catnilai <br> $_POST[catatan]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=peserta&affect=ya&id_kategorinilai='.$_POST[id_kategorinilai].'');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=peserta&affect=tdk&id_kategorinilai='.$_POST[id_kategorinilai].'');
  		}  	
  }
}

// Update penilaian
elseif ($module=='penilaian' AND $act=='update'){
	  logging($module,update,$_POST['id']);

    mysql_query("UPDATE penilaian SET penilaian = '$_POST[penilaian]' , catatan='$_POST[catatan]' WHERE id_penilaian = '$_POST[id]'");
 	
 	if(mysql_affected_rows() > 0){      
        
        header('location:../../media.php?module='.$module.'&act=peserta&affect=ya&id_kategorinilai='.$_POST[id_kategorinilai].'');
      }
      else{
        header('location:../../media.php?module='.$module.'&act=peserta&affect=tdk&id_kategorinilai='.$_POST[id_kategorinilai].'');
      }
}
}
?>
