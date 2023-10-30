<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

echo"PELAYANAN DI JEMAAT <br>
   <table style border='1'>
   <thead><tr>
   <th>No</th>
   <th>No SK</th>
   <th>Tanggal SK</th>
   <th>Gereja</th>
   <th>Wilayah</th>
   <th>Ketua BPMJ</th>
   <th>Ketua BPMW</th>
   <th>Sentralisasi</th>
   <th>Tahun Mulai - Selesai</th>
   </tr></thead>
   <tbody>";

   $tampil = mysql_query("SELECT wilayah.wilayah, fungsional.id_fungsional, fungsional.noskfungsional, fungsional.tanggalsk,  gereja.gereja, gereja.id_gereja, fungsional.tahunmulai, fungsional.tahunselesai, fungsional.bpmj, fungsional.bpmw FROM fungsional, gereja, wilayah where fungsional.id_pekerja='$_GET[id_pekerja]' and gereja.id_gereja=fungsional.id_gereja and gereja.id_wilayah=wilayah.id_wilayah");

    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
    
  if($r['noskfungsional']==""){
    $show="tidak tahu";
  }
  else{
    $show=$r['noskfungsional'];
  }
  
  if($r['tahunselesai']==0){
    $selesai="sekarang";
  }
  else{
    $selesai="$r[tahunselesai]";
  }
  
  $tglfungsional = $r['tanggalsk'];
      if($tglfungsional=="0000-00-00"){
      $datefungsional2="tidak tahu"; 
    }
    else{
      $datefungsional = date_create($tglfungsional);
      $datefungsional2= date_format($datefungsional, 'd-m-Y');
    }

  echo "<tr> 
  <td>$no</td>
  <td>$r[noskfungsional]</td>
  <td>$datefungsional2</td>
  <td>$r[gereja]</td>
  <td>$r[wilayah]</td>
  <td>$r[bpmj]</td>
  <td>$r[bpmw]</td>
  <td><a href=?module=apbj&id_gereja=$r[id_gereja] title='Sentralisasi' class='with-tip'>Lihat</a></td>
  <td>$r[tahunmulai]-$selesai</td>
  </tr>";
  
  $no++;
}
echo"</tbody></table> <br><br>";


echo"        
    LEMBAGA LAINNYA <br>
   <table style border='1'>

   <thead><tr>
      
   <th>No</th>
   <th>No SK</th>
   <th>Tanggal SK</th>
   <th>Jenis Lembaga</th>
   <th>Tahun Mulai - Selesai</th>
 
   </thead>
   <tbody>";

  $tampil = mysql_query("SELECT struktural.id_struktural, struktural.noskstruktural, struktural.tanggalsk,  jenislembaga.jenislembaga, struktural.tahunmulai, struktural.tahunselesai FROM struktural, jenislembaga where struktural.id_pekerja='$_GET[id_pekerja]' and jenislembaga.id_jenislembaga=struktural.id_jenislembaga");
    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){ 
  
  if($r['noskstruktural']==""){
    $show="tidak tahu";
  }
  else{
    $show=$r['noskstruktural'];
  }
  
  if($r['tahunselesai']==0){
    $selesai="sekarang";
  }
  else{
    $selesai="$r[tahunselesai]";
  }
  
  $tglstruktural = $r['tanggalsk'];
      if($tglstruktural=="0000-00-00"){
      $datestruktural2="tidak tahu"; 
    }
    else{
      $datestruktural = date_create($tglstruktural);
      $datestruktural2= date_format($datestruktural, 'd-m-Y');
    }

       echo "<tr> 
  <td width=50><center>$no</center></td>
  <td>$r[noskstruktural]</td>
  <td>$datestruktural2</td>
  <td>$r[jenislembaga]</td>
  <td>$r[tahunmulai]-$selesai</td>
  </tr>";  
  
      $no++;
      }
echo "</tbody></table> <br><br>";

   echo"        
   TUG<br>
   <table style border='1'>

   <thead><tr>
      
   <th>No</th>
   <th>No SK</th>
   <th>Tanggal SK</th>
   <th>Tempat TUG</th>
   <th>Tahun Mulai - Selesai</th>
 </thead>
   <tbody>";

    
    $tampil = mysql_query("SELECT tug.id_tug, tug.nosktug, tug.tanggalsk,  tempattug.tempattug, tug.tahunmulai, tug.tahunselesai FROM tug, tempattug where tug.id_pekerja='$_GET[id_pekerja]' and tempattug.id_tempattug=tug.id_tempattug");
    
    $no = 1;
    while($r=mysql_fetch_array($tampil)){
    
  if($r['nosktug']==""){
    $show="tidak tahu";
  }
  else{
    $show=$r['nosktug'];
  }
  
  if($r['tahunselesai']==0){
    $selesai="sekarang";
  }
  else{
    $selesai="$r[tahunselesai]";
  }
  
  $tgltug = $r['tanggalsk'];
      if($tgltug=="0000-00-00"){
      $datetug2="tidak tahu"; 
    }
    else{
      $datetug = date_create($tgltug);
      $datetug2= date_format($datetug, 'd-m-Y');
    }

       echo "<tr class=gradeX> 
  <td>$no</td>
  <td>$r[nosktug]</td>
  <td>$datetug2</td>
  <td>$r[tempattug]</td>
  <td>$r[tahunmulai]-$selesai</td>
  
   </td></tr>";  
  
      $no++;
      }
echo "</tbody></table> ";


}
?>