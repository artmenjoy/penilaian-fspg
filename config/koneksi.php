<?php

// panggil fungsi validasi xss dan injection
require_once('fungsi_validasi.php');

$server =  "localhost";
$username = "root";
$password = "usbw";
$database = "retel";

// Koneksi dan memilih database di server
$link=mysql_connect($server,$username,$password);

if (!$link) {
    die('Tidak bisa koneksi ke database: ' . mysql_error());
}

mysql_select_db($database) or die("Database tidak bisa dibuka");

// buat variabel untuk validasi dari file fungsi_validasi.php
$val = new Rizalvalidasi;

function generateid($module){
	a:
	$acak=rand(1000000,9999999);
	session_start();
	$id=$_SESSION[id_jemaat].$acak;
	$bandingkan=mysql_query("select * from $module where id_$module='$id'");
	$bandingkan2=mysql_num_rows($bandingkan);
	if ($bandingkan2 > 0){
		goto a;
	}else{
		return $id;
	}
}
?>
