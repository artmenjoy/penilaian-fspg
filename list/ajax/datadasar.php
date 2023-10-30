<?php
session_start();
 if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
  echo "<link href='style.css' rel='stylesheet' type='text/css'>
 <center>Untuk mengakses modul, Anda harus login <br>";
  echo "<a href=../../index.php><b>LOGIN</b></a></center>";
}
else{
include "../../../config/koneksi.php";

$ambil=mysql_query("select * from pekerja where id_pekerja='$_GET[id_pekerja]'");
$ambil2=mysql_fetch_array($ambil);

$goldarah=mysql_query("select goldarah from gol_darah where id_goldarah='$ambil2[id_goldarah]'");
$gol_darah2=mysql_fetch_array($goldarah);

$etnis=mysql_query("select etnis from etnis where id_etnis='$ambil2[id_etnis]'");
$etnis2=mysql_fetch_array($etnis);

$statuspekerja=mysql_query("select statuspekerja from statuspekerja where id_statuspekerja='$ambil2[id_statuspekerja]'");
$statuspekerja2=mysql_fetch_array($statuspekerja);
echo"
<table>
<tr>
<td>Foto</td>
<td><img src= '../foto_pekerja/small_$ambil2[foto]'/></td>
</tr>
 
<tr>
<td>Nama</td>
<td>: $ambil2[pekerja]$tulis</td>
</tr>
<tr>
<td>Tempat Lahir</td>
<td>: $ambil2[tempatlahir]</td>
</tr>
<tr>
<td>Tanggal Lahir</td>
<td>: $date2</td>
</tr>
<tr>
<td>Kelamin</td>
<td>: $ambil2[kelamin]</td>
</tr>
<tr>
<td>Alamat Sekarang</td>
<td>: $ambil2[alamatsekarang]</td>
</tr>
<tr>
<td>Telepon</td>
<td>: $ambil2[telepon]</td>
</tr>
<tr>
<td>Email</td>
<td>: $ambil2[email]</td>
</tr>
<tr>
<td>Golongan Darah</td>
<td>: $gol_darah2[goldarah]</td>
</tr>
<tr>
<td>Banyak Saudara</td>
<td>: $ambil2[banyaksaudara]</td>
</tr>
<tr>
<td>Anak Ke</td>
<td>: $ambil2[anakke]</td>

</tr>
<tr>
<td>Etnis</td>
<td>: $etnis2[etnis]</td>
</tr>
<tr>
<td>Status Pekerja</td>
<td>: $statuspekerja2[statuspekerja]</td>
</tr>
<tr>
<td>Baptis</td>
<td>: $baptis</td>
</tr>
<tr>
<td>Sidi</td>
<td>: $sidi</td>
</tr>

<tr>
<td>SK PO</td>
<td>: $ambil2[skpo]</td>
</tr>

<tr>
<td>Tanggal SK PO</td>
<td>: $ambil2[tanggalskpo]</td>
</tr>

<tr>
<td>Tanggal Penetapan PO</td>
<td>: $ambil2[tanggalpenetapanpo]</td>
</tr>
</table>
";
}
?>