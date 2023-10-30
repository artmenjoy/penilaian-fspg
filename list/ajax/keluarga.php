<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

echo"			  
	KELUARGA <br>
   <table style border='1'>

   <thead><tr>
		  
   <th>No</th>
   <th>Nama Keluarga</th>
   <th>Tanggal Nikah</th>
   <th>Status Nikah</th>
   </thead>
   <tbody>";

    $tampil = mysql_query("SELECT * FROM nikah where id_pekerja='$_GET[id_pekerja]'");
    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
    
	if($r[tanggalnikah]!='0000-00-00') {
		$casingnikah="$r[tanggalnikah]";
	}
	else{
			$casingnikah="tidak tahu";
	}
	
	
       echo "<tr class=gradeX> 
  <td width=50><center>$no</center></td>
  <td>$r[keluarga]</td>
  <td>$casingnikah</td>
  <td>$r[statusnikah]</td>
  </tr>";  
  
      $no++;
}
echo "</tbody></table> ";

   echo"<br><br>			  
   ANGGOTA KELUARGA <br>
   <table style border='1'>

   <thead><tr>
		  
   <th>No</th>
   <th>Nama</th>
   <th>Keluarga</th>
   <th>Kelamin</th>
   <th>Relasi</th>
   <th>TTL</th>
   <th>Etnis</th>
   <th>Pekerjaan</th>
   <th>Lokasi Kerja</th>
   <th>ALm</th>
    </thead>
   <tbody>";
   
      $tampil = mysql_query("SELECT anggotakeluarga.alm, nikah.keluarga, kelurahan.kelurahan, kecamatan.kecamatan, kabkota.kabkota, anggotakeluarga.tempatlahir, anggotakeluarga.tanggallahir, etnis.etnis, pekerjaan.pekerjaan, anggotakeluarga.kelamin, relasikeluarga.relasikeluarga, anggotakeluarga.id_anggotakeluarga, anggotakeluarga.anggotakeluarga FROM anggotakeluarga, pekerja, relasikeluarga, nikah, etnis, pekerjaan, kelurahan, kecamatan, kabkota where anggotakeluarga.id_etnis=etnis.id_etnis and anggotakeluarga.id_pekerjaan=pekerjaan.id_pekerjaan and anggotakeluarga.id_kelurahan=kelurahan.id_kelurahan and kelurahan.id_kecamatan=kecamatan.id_kecamatan and kecamatan.id_kabkota=kabkota.id_kabkota and anggotakeluarga.id_nikah=nikah.id_nikah and nikah.id_pekerja='$_GET[id_pekerja]' and nikah.id_pekerja=pekerja.id_pekerja and anggotakeluarga.id_relasikeluarga = relasikeluarga.id_relasikeluarga");
    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
    
       echo "<tr class=gradeX> 
  <td><center>$no</center></td>
  <td>$r[anggotakeluarga]</td>
  <td>$r[keluarga]</td>
  <td>$r[kelamin]</td>
  <td>$r[relasikeluarga]</td>
  <td>$r[tempatlahir] , $r[tanggallahir]</td>
  <td>$r[etnis]</td>
  <td>$r[pekerjaan]</td>
  <td>$r[kabkota] - $r[kecamatan] - $r[kelurahan]</td>
  <td>$r[alm]</td>
  </tr>";  
  
      $no++;
      }
echo "</tbody></table> ";

}
?>