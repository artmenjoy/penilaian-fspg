<?php
include "config/koneksi.php";
include "config/timer.php";

function anti_injection($data){
	$filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
	return $filter;
}

$username = anti_injection($_POST['username']);
$pass     = anti_injection(md5($_POST['password']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($username) OR !ctype_alnum($pass)){
	echo "Sekarang loginnya tidak bisa diinjeksi.";
}else{
	$login=mysql_query("SELECT users.*,userslevel.userslevel FROM users, userslevel WHERE users.id_userslevel=userslevel.id_userslevel AND username='$username' AND password='$pass' AND blokir='T'");
	$ketemu=mysql_num_rows($login);
	$r=mysql_fetch_array($login);

	// Apabila username dan password ditemukan
	if($ketemu > 0){
		session_start();
		$_SESSION[namauser]     = $r[username];
		$_SESSION[namalengkap]  = $r[namalengkap];
		$_SESSION[passuser]     = $r[password];
		$_SESSION[sessid]       = $r[id_session];
		$_SESSION[leveluser]    = $r[userslevel];
		
		if($r[userslevel]=='userjemaat'){
			$loginj=mysql_query("select usersjemaat.*, jemaat.jemaat from usersjemaat, jemaat where usersjemaat.id_jemaat=jemaat.id_jemaat and username='$r[username]' ");
			$j=mysql_fetch_array($loginj);
			$_SESSION[id_jemaat]= $j[id_jemaat];
			$_SESSION[jemaat] 	= $j[jemaat];
		}

		login_validate();
		header('location:media.php?module=home');
	
	}else{
		header('location:index.php?affect=tdk');
	}
}
?>
