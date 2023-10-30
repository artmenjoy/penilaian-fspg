<?php
include "../../../config/koneksi.php";

   echo"

   BAPTIS <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>No Surat Baptis</th>
   <th>Pendeta</th>
   <th>Tanggal Baptis</th>
   <th>Gereja</th>
   <th>Gereja Lain</th>
   
   ";

    $no=1;
    $tampil = mysql_query("SELECT baptispekerja.no_suratbaptis, baptispekerja.pendeta, baptispekerja.tanggalbaptis, gereja.gereja, baptispekerja.gerejalain from baptispekerja, gereja where baptispekerja.id_gereja=gereja.id_gereja and baptispekerja.id_pekerja='$_GET[id_pekerja]'");
   
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[no_suratbaptis]</td>
  <td>$r[pendeta]</td>
  <td>$r[tanggalbaptis]</td>
  <td>$r[gereja]</td>
  <td>$r[gerejalain]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> <br><br>";

   echo"

   SIDI <br>
   <table style border='1'>
   <tr>
   <th>No</th>
   <th>No Surat Sidi</th>
   <th>Tanggal Sidi</th>
   <th>Gereja</th>
   <th>Pendeta</th>
   
   ";

    $no=1;
    $tampil = mysql_query("SELECT sidipekerja.no_suratsidi, sidipekerja.tanggalsidi, sidipekerja.pendeta, gereja.gereja from sidipekerja, gereja where sidipekerja.id_gereja=gereja.id_gereja and sidipekerja.id_pekerja='$_GET[id_pekerja]'");
    while($r=mysql_fetch_array($tampil)){
    
  echo "<tr> 
  <td>$no</center></td>
  <td>$r[no_suratsidi]</td>
  <td>$r[tanggalsidi]</td>
  <td>$r[pendeta]</td>
  <td>$r[gereja]</td>
  </tr>";  
  
      $no++;
      }
echo "</table> ";


?>