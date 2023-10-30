<?php
function logging($module,$aksi,$id){
    
if($aksi=='isi'){
	$log="";
	$tabel = mysql_query("SELECT * FROM $module");
	for($i = 0; $i < mysql_num_fields($tabel); $i++){
		$col = mysql_field_name($tabel, $i);
		$ganti = str_replace("id_", "", "$col");
		if($ganti!=$col){
			$cari=mysql_query("select $ganti from $ganti where id_$ganti='$_POST[$col]'");
			$cari2=mysql_fetch_array($cari);
			$log= "$log $ganti : $cari2[$ganti] -";
		}
		else{
			$log= "$log $col : $_POST[$col] -";		
		}

	}
	$sql2 = "INSERT INTO sejarah(user, modul, isi) VALUES('$_SESSION[namauser]','$module', '$log')";
	mysql_query($sql2);
}
elseif($aksi=='update'){
	$log="";
	$tabel = mysql_query("SELECT * FROM $module where id_$module='$id'");
	$tabel22=mysql_fetch_array($tabel);
	for($i = 0; $i < mysql_num_fields($tabel); $i++){
		$col = mysql_field_name($tabel, $i);
		$ganti = str_replace("id_", "", "$col");
		if($ganti!=$col){
			$cari=mysql_query("select $ganti from $ganti where id_$ganti='$tabel22[$col]'");
			$cari2=mysql_fetch_array($cari);
			$log= "$log $ganti : $cari2[$ganti] -";
		}
		else{
			$log= "$log $col : $tabel22[$col] -";		
		}

	}

	$log2="";
	$tabel2 = mysql_query("SELECT * FROM $module");
	for($i2 = 0; $i2 < mysql_num_fields($tabel2); $i2++){
		$col2 = mysql_field_name($tabel2, $i2);
		$ganti2 = str_replace("id_", "", "$col2");
		if($ganti2!=$col2){
			$cari22=mysql_query("select $ganti2 from $ganti2 where id_$ganti2='$_POST[$col2]'");
			$cari222=mysql_fetch_array($cari22);
			$log2= "$log2 $ganti2 : $cari222[$ganti2] -";
		}
		else{
			$log2= "$log2 $col2 : $_POST[$col2] -";		
		}

	}

	$sql2 = "INSERT INTO sejarah(user, modul, isi, ubah) VALUES('$_SESSION[namauser]','$module', '$log','$log2')";
	mysql_query($sql2);
}
else{
	$log="";
	$tabel = mysql_query("SELECT * FROM $module where id_$module='$id'");
	$tabel22=mysql_fetch_array($tabel);
	for($i = 0; $i < mysql_num_fields($tabel); $i++){
		$col = mysql_field_name($tabel, $i);
		$ganti = str_replace("id_", "", "$col");
		if($ganti!=$col){
			$cari=mysql_query("select $ganti from $ganti where id_$ganti='$tabel22[$col]'");
			$cari2=mysql_fetch_array($cari);
			$log= "$log $ganti : $cari2[$ganti] -";
		}
		else{
			$log= "$log $col : $tabel22[$col] -";		
		}

	}

	$sql2 = "INSERT INTO sejarah(user, modul, hapus) VALUES('$_SESSION[namauser]','$module', '$log')";
	mysql_query($sql2);	
}	
}  
?>
