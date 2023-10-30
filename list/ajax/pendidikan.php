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

   PENDIDIKAN FORMAL <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>Jenjang</th>
   <th>Institusi Pendidikan</th>
   <th>Jurusan</th>
   <th>Spesialisasi</th>
   <th>Tahun Masuk-Lulus</th>
   <th>Judul Tugas Akhir</th>
   <th>Gelar</th>
   ";

    $no=1;
    $tampil = mysql_query("SELECT pendidikanpekerja.jurusan, pendidikanpekerja.tahunmasuk, pendidikanpekerja.tahunlulus, pendidikanpekerja.judulkaryailmiah, pendidikan.pendidikan, gelar.gelar, universitas.universitas, spesialisasi.spesialisasi FROM pendidikanpekerja, gelar, universitas, pendidikan, spesialisasi where pendidikanpekerja.id_gelar=gelar.id_gelar and pendidikanpekerja.id_universitas=universitas.id_universitas and pendidikanpekerja.id_spesialisasi=spesialisasi.id_spesialisasi and pendidikanpekerja.id_pendidikan=pendidikan.id_pendidikan and pendidikanpekerja.id_pekerja='$_GET[id_pekerja]'");
   
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[pendidikan]</td>
  <td>$r[universitas]</td>
  <td>$r[jurusan]</td>
  <td>$r[spesialisasi]</td>
  <td>$r[tahunmasuk]-$r[tahunlulus]</td>
  <td>$r[judulkaryailmiah]</td>
  <td>$r[gelar]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> <br><br>";

   echo"

   PENDIDIKAN NON FORMAL <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>Pendidikan Non Formal</th>
   <th>Jenis</th>
   <th>Penyelenggara</th>
   <th>Tahun</th>
   
   ";

    $no=1;
    $tampil = mysql_query("SELECT pendidikannonformalpekerja.pendidikannonformalpekerja, pendidikannonformalpekerja.penyelenggara, pendidikannonformalpekerja.tahun, jenispendidikannonformal.jenispendidikannonformal FROM pendidikannonformalpekerja, jenispendidikannonformal where jenispendidikannonformal.id_jenispendidikannonformal=pendidikannonformalpekerja.id_jenispendidikannonformal and pendidikannonformalpekerja.id_pekerja='$_GET[id_pekerja]'");
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[pendidikannonformalpekerja]</td>
  <td>$r[jenispendidikannonformal]</td>
  <td>$r[penyelenggara]</td>
  <td>$r[tahun]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> ";

}
?>