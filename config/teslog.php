<?php

	$url     = $_SERVER['REQUEST_URI'];
	$ip      = $_SERVER['REMOTE_ADDR'];
	$tanggal = date('Y-m-d H:i:s');
	$pemakai= $_SESSION['namauser'];

	
	if(isset($_GET['module']) and $_GET['act']=='hapus' or $_GET['act']=='input' or $_GET['act']=='update'){

		mysql_query("INSERT INTO `log` (`user`, `waktuakses`, `ip`, `url`, `modul`, `action`, `databaru`, `datalama`) 
		VALUES ('$pemakai', '$tanggal', '$ip', '$url' ,'$_GET[module]', '$_GET[act]', '', '')");

	}
	else{
		mysql_query("INSERT INTO `log` (`user`, `waktuakses`, `ip`, `url`, `modul`, `action`) 
		VALUES ('$pemakai', '$tanggal', '$ip', '$url' ,'$_GET[module]', '$_GET[act]')");	
	}


?>
