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

   VIKARIS <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>No SK Vikaris</th>
   <th>Tanggal Vikaris</th>
   <th>Mentor</th>
   <th>Gereja</th>
   
   ";

    $no=1;
    $tampil = mysql_query("SELECT vikaris.noskvikaris, vikaris.tanggalsk, vikaris.mentor, gereja.gereja from vikaris, gereja where vikaris.id_gereja=gereja.id_gereja and vikaris.id_pekerja='$_GET[id_pekerja]'");
   
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[noskvikaris]</td>
  <td>$r[tanggalsk]</td>
  <td>$r[mentor]</td>
  <td>$r[gereja]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> <br><br>";

   echo"

   DITEGUHKAN <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>No SK</th>
   <th>Tanggal SK</th>
   <th>Tanggal Diteguhkan</th>
   <th>Gereja</th>
   <th>Diteguhkan Oleh</th>
   
   ";

    $no=1;
    $tampil = mysql_query("SELECT diteguhkan.noskditeguhkan, diteguhkan.tanggalsk, diteguhkan.tanggalditeguhkan, diteguhkan.diteguhkanoleh, gereja.gereja from diteguhkan, gereja where diteguhkan.id_gereja=gereja.id_gereja and diteguhkan.id_pekerja='$_GET[id_pekerja]'");
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[noskditeguhkan]</td>
  <td>$r[tanggalsk]</td>
  <td>$r[tanggalditeguhkan]</td>
  <td>$r[gereja]</td>
  <td>$r[diteguhkanoleh]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> ";

}
?>