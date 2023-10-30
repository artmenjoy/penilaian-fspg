<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../config/koneksi.php";

$module=$_GET['module'];
$act=$_GET['act'];

// Hapus 
if ($module=='user' AND $act=='hapus'){
	$id=$_SESSION['passuser'];
	$link = "?module=".$module;
	$cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));
	
	if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
		header('location:../../media.php?module='.$module.'&affect=tdk2');
	}else{
		mysql_query("DELETE FROM users WHERE username='$_GET[id]'");
 		
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
elseif ($module=='user' AND $act=='input'){
	$session = md5($_POST[username]);
	$bandingkan=mysql_query("select * from users where username='$_POST[username]' OR id_session='$session' ");
	$bandingkan2=mysql_num_rows($bandingkan);
	if ($bandingkan2 > 0){
  		header('location:../../media.php?module='.$module.'&act=tambah'.$module.'&err=ada');
	}else {
	$password = md5($_POST[password]);
	$sql = "INSERT INTO users(namalengkap,  id_userslevel, id_grupakses, username, password, email, notelp, blokir, id_session) VALUES('$_POST[namalengkap]', 2,'$_POST[id_grupakses]', '$_POST[username]', '$password', '$_POST[email]', '$_POST[notelp]', '$_POST[blokir]', '$session')";
	mysql_query($sql);
  		if(mysql_affected_rows() > 0){  				
  			$modul = $_POST[modul];
  			if(!empty($modul)){
  				$n = count($modul);
  				for ($i=0; $i<$n; $i++) { 
  					$sql2 = "INSERT INTO usersmodul(id_session, id_modul) VALUES('$session', $modul[$i])";
  					mysql_query($sql2);
  				}
  			}
  			header('location:../../media.php?module='.$module.'&act=&affect=ya');
  		}else{
  			header('location:../../media.php?module='.$module.'&act=tambah'.$module.'&affect=tdk');
  		}  	
	}
}
// Update
elseif ($module=='user' AND $act=='update'){
	$session = md5($_POST[id]);
	$bandingkan=mysql_query("select * from users where username!='$_POST[id]' and id_session='$session'");
	$bandingkan2=mysql_num_rows($bandingkan2);
	if ($bandingkan2 > 0){
  		header('location:../../media.php?module='.$module.'&act=edit'.$module.'&id='.$session.'&err=ada');
	}else{
		if(!empty($_POST[passwordbaru])){
			$password = md5($_POST[passwordbaru]);
			$sql = "UPDATE users 
					SET 
						namalengkap = '$_POST[namalengkap]', 
						password 	= '$password', 
						id_grupakses= '$_POST[id_grupakses]',
						email 		= '$_POST[email]', 
						notelp 		= '$_POST[notelp]',
						blokir 		= '$_POST[blokir]'
					WHERE id_session= '$_POST[id]'";
		}else{
			$sql = "UPDATE users 
					SET 
						namalengkap = '$_POST[namalengkap]',
						id_grupakses= '$_POST[id_grupakses]', 
						email 		= '$_POST[email]', 
						notelp 		= '$_POST[notelp]',
						blokir 		= '$_POST[blokir]'
					WHERE id_session= '$_POST[id]'";

		}
		mysql_query($sql);
		if(mysql_affected_rows() > 0){  			
  			header('location:../../media.php?module='.$module.'&affect=ya');
  		}else{
  			header('location:../../media.php?module='.$module.'&act=edit'.$module.'$id='.$session.'&affect=tdk');
  		}
	}
}


}
?>
