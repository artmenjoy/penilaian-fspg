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

// Hapus 
if ($module=='modul' AND $act=='hapus'){
	$id=$_SESSION['passuser'];
	$link = "?module=".$module;
	$cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));
	
	if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
		header('location:../../media.php?module='.$module.'&affect=tdk2');
	}else{
		logging($module,hapus,$_GET['id']);

		mysql_query("DELETE FROM modul WHERE id_modul='$_GET[id]'");
 		
 		if(mysql_errno()==1451){ //dependensi dengan field lain (restrict)
			header('location:../../media.php?module='.$module.'&err=sql');
		}
		elseif(mysql_affected_rows() > 0){
			header('location:../../media.php?module='.$module.'&affect=ya2');
		}
		else{  		
			header('location:../../media.php?module='.$module.'&affect=tdk2');
		}
	}	
}

// Input 
elseif ($module=='modul' AND $act=='input'){
	$bandingkan=mysql_query("select * from users where link='$_POST[link]' ");
	$bandingkan2=mysql_num_rows($bandingkan);
	
	if ($bandingkan2 > 0){
  		header('location:../../media.php?module='.$module.'&act=tambah'.$module.'&err=ada');
	}else {

	logging($module,isi,'');

	$sql  = "INSERT INTO modul(modul,  link, aktif, icon, id_parent,urutan) VALUES('$_POST[modul]', '$_POST[link]', '$_POST[aktif]', '$_POST[icon]', '$_POST[id_parent]','$_POST[urutan]')";
	mysql_query($sql);
	
  		if(mysql_affected_rows() > 0){  				
  			header('location:../../media.php?module='.$module.'&act=&affect=ya');
  		}else{
  			header('location:../../media.php?module='.$module.'&act=tambah'.$module.'&affect=tdk');
  		} 	
	}
}

// Update
elseif ($module=='modul' AND $act=='update'){
	$bandingkan=mysql_query("select * from users where id_modul!='$_POST[id]' and link='$_POST[link]'");
	$bandingkan2=mysql_num_rows($bandingkan2);
	if ($bandingkan2 > 0){
  		header('location:../../media.php?module='.$module.'&act=edit'.$module.'&id='.$_POST[id].'&err=ada');
	}else{
		logging($module,update,$_POST['id']);

		$sql = "UPDATE modul 
					SET 
						modul 	= '$_POST[modul]', 
						link 		= '$_POST[link]', 
						aktif 		= '$_POST[aktif]',
						icon = '$_POST[icon]',
						id_parent = '$_POST[id_parent]',
						urutan = '$_POST[urutan]'
					WHERE id_modul	= '$_POST[id]'";
		mysql_query($sql);
		if(mysql_affected_rows() > 0){  			
  			header('location:../../media.php?module='.$module.'&affect=ya');
  		}else{
  			header('location:../../media.php?module='.$module.'&act=edit'.$module.'$id='.$_POST[id].'&affect=tdk');
  		}
	}
}

}
?>
