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

   <table style border='1'>
   <thead><tr>
	 <th>No</th>
   <th>Penyakit Pekerja</th>
   <th>Tahun</th>
   <th>Sekarang</th>
   
   </thead>
   <tbody>";

    $tampil = mysql_query("SELECT penyakitpekerja.tahun, penyakitpekerja.sekarang, jenispenyakit.jenispenyakit FROM jenispenyakit, penyakitpekerja where jenispenyakit.id_jenispenyakit=penyakitpekerja.id_jenispenyakit and penyakitpekerja.id_pekerja='$_GET[id_pekerja]'");
    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
  
       echo "<tr class=gradeX> 
  <td><center>$no</center></td>
  <td>$r[jenispenyakit]</td>
  <td>$r[tahun]</td>
  <td>$r[sekarang]</td>
  </tr>";  
  
      $no++;
      }
      
echo "</tbody></table> ";
}
?>