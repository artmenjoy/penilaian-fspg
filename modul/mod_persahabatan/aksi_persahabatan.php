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

// Hapus persahabatan
if ($module=='persahabatan' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM persahabatan WHERE id_persahabatan='$_GET[id]'");
 		
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

// Input persahabatan
elseif ($module=='persahabatan' AND $act=='input'){

  if($_POST['peserta1']=='' or $_POST['peserta2']=='' or $_POST['peserta3']==''){
      
    header('location:../../media.php?module='.$module.'&act=tambahpersahabatan&affect=tdk');
    
  }
  elseif($_POST['peserta1']==$_POST['peserta2'] or $_POST['peserta1']==$_POST['peserta3'] or $_POST['peserta3']==$_POST['peserta2']){
    header('location:../../media.php?module='.$module.'&act=tambahpersahabatan&affect=tdk');
  }
  else{

    mysql_query("INSERT INTO persahabatan(id_peserta) VALUES('$_POST[peserta1]')");
    mysql_query("INSERT INTO persahabatan(id_peserta) VALUES('$_POST[peserta2]')");
    mysql_query("INSERT INTO persahabatan(id_peserta) VALUES('$_POST[peserta3]')");
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahpersahabatan&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahpersahabatan&affect=tdk');
  		}  	
  }
}
elseif ($module=='persahabatan' AND $act=='reset'){
  mysql_query("DELETE from persahabatan where id_persahabatan > 0");

      if(mysql_affected_rows() > 0){      
        
        header('location:../../media.php?module='.$module.'&affect=ya');
      }
      else{
        header('location:../../media.php?module='.$module.'&affect=tdk');
      }   
}


}
?>
