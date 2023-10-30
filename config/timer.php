<?php

//fungsi untuk outomatik logout
function login_validate() {
	//ukuran waktu dalam detik
	$timer=3600;
	//untuk menambah masa validasi
	$_SESSION["expires_by"] = time() + $timer;
}

function login_check() {
	//mengambil nilai session pertama
	$exp_time = $_SESSION["expires_by"];
	//jika waktu sistem lebih kecil dari nilai waktu session
	if (time() < $exp_time) {
		//panggil fungsi dan tambah waktu session
		login_validate();
		return true; 
	}else{
		//jika waktu session lebih kecil dari waktu session atau lewat batas
		//unset session
		unset($_SESSION["expires_by"]);
		return false; 
	}
}

?>