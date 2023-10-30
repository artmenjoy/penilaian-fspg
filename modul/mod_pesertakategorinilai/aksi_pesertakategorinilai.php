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

// Hapus pesertakategorinilai
if ($module=='pesertakategorinilai' AND $act=='hapus'){
	
	$id=$_SESSION['passuser'];
  $link = "?module=".$module;
  $cekcrud = mysql_num_rows(mysql_query("SELECT modul.id_modul FROM users,modul,grupakses,aksescrud WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and aksescrud.id_modul=modul.id_modul and users.username='$_SESSION[namauser]' and aksescrud.hapus='y' and modul.modul='$module'"));

  if($cekcrud < 1 and $_SESSION['leveluser']!='admin'){
    header('location:../../media.php?module='.$module.'&affect=tdk2');
  }

  else{
	logging($module,hapus,$_GET['id']);

  mysql_query("DELETE FROM pesertakategorinilai WHERE id_peserta='$_GET[id]'");
 		
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

// Input pesertakategorinilai
elseif ($module=='pesertakategorinilai' AND $act=='input'){
  $kategori=mysql_query("select * from kategorinilai");
  while($kategori2=mysql_fetch_array($kategori)){
    $cat=$kategori2['id_kategorinilai'];
    if($_POST[$cat]>0){
      //echo "cat $_POST[$cat] pserta $_POST[id_peserta] <br>";
    
      mysql_query("INSERT INTO `pesertakategorinilai` (`id_peserta`, `id_kategorinilai`) 
        VALUES ('$_POST[id_peserta]', '$_POST[$cat]')");

    }
  }
  		if(mysql_affected_rows() > 0){  		
  			
  			header('location:../../media.php?module='.$module.'&act=tambahpesertakategorinilai&affect=ya');
  		}
  		else{
  			header('location:../../media.php?module='.$module.'&act=tambahpesertakategorinilai&affect=tdk');
  		}  	

}

// Update pesertakategorinilai
elseif ($module=='pesertakategorinilai' AND $act=='update'){
  $kategori=mysql_query("select * from kategorinilai");
  while($kategori2=mysql_fetch_array($kategori)){
    $cat=$kategori2['id_kategorinilai'];
    if($_POST[$cat]>0){
      //echo "cat $_POST[$cat] pserta $_POST[id_peserta] <br>";
      $cekkategori=mysql_query("select * from pesertakategorinilai where id_peserta='$_POST[id_peserta]' and id_kategorinilai='$kategori2[id_kategorinilai]'");
      $cekkategori2=mysql_num_rows($cekkategori);
      if($cekkategori2 < 1){
        mysql_query("INSERT INTO `pesertakategorinilai` (`id_peserta`, `id_kategorinilai`) 
        VALUES ('$_POST[id_peserta]', '$_POST[$cat]')");
      }

    }
    else{
      $cekkategori=mysql_query("select * from pesertakategorinilai where id_peserta='$_POST[id_peserta]' and id_kategorinilai='$kategori2[id_kategorinilai]'");
      $cekkategori2=mysql_num_rows($cekkategori);
      if($cekkategori2 > 0){
        mysql_query("DELETE from pesertakategorinilai where id_peserta='$_POST[id_peserta]' and id_kategorinilai='$kategori2[id_kategorinilai]'");
      }
    }
  }
      if(mysql_affected_rows() > 0){      
        
        header('location:../../media.php?module='.$module.'&affect=ya');
      }
      else{
        header('location:../../media.php?module='.$module.'&affect=ya');
      }   

}
}
?>
