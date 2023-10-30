<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
  <meta http-equiv="content-type"
 content="text/html; charset=ISO-8859-1">
  <title></title>
</head>
<body>
<div style="text-align: center;"><big>KOMISI
PELAYANAN REMAJA<br>
WILAYAH KALAWAT I<br>
<br>
</big><br>
</div>
<br>
<?php include "/config/koneksi.php";
$tampil = mysql_query("SELECT * from peserta where id_peserta='$_GET[id]'");
$r=mysql_fetch_array($tampil);
?>
<table style="text-align: left; width: 1000px;" border="0"
 cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="text-align: right; width: 404px;">Nama:</td>
      <td style="width: 576px;"><?php echo"$r[peserta]"; ?></td>
    </tr>
    <tr>
      <td style="text-align: right; width: 404px;">Jemaat:</td>
      <td style="width: 576px;"><?php echo"$r[jemaat]"; ?></td>
    </tr>
  </tbody>
</table>
<br>
<br>
<div style="text-align: center;"><br>
</div>
<table style="text-align: left; width: 1000px;" border="1"
 cellpadding="1" cellspacing="1">
  <tbody>
    <tr>
      <td style="text-align: center;">Poin Penilaian</td>
      <td style="text-align: center;">Nilai Kategori</td>
      <td style="text-align: center;">Persentase Nilai</td>
      <td style="text-align: center;">Nilai</td>
    </tr>
<?php $totalnilai=0;
$kategori3=mysql_query("select * from kategorinilai");
while($kategori4=mysql_fetch_array($kategori3)){
$ceknilai=mysql_query("select avg(penilaian) as rata from penilaian where id_peserta='$r[id_peserta]' and id_kategorinilai='$kategori4[id_kategorinilai]'");
$ceknilai2=mysql_fetch_array($ceknilai);
$last=$ceknilai2['rata']*($kategori4['persentasenilai']/100);
$totalnilai=$totalnilai+$last;
$bulat1=round($last,2);
$nilaikategori=mysql_query("select * from penilaian where id_kategorinilai='$kategori4[id_kategorinilai]' and id_peserta='$r[id_peserta]'");
$nilaikategori2=mysql_fetch_array($nilaikategori);
echo"
<tr>
<td>$kategori4[kategorinilai]</td>
<td>$ceknilai2[rata]</td>
<td>$kategori4[persentasenilai]</td>
<td>$bulat1</td>
</tr>
";
}
$bulat2=round($totalnilai,3);
echo"
<tr>
<td>Total Nilai</td>
<td></td>
<td>100%</td>
<td>$bulat2</td>
</tr>
";
echo"
<tr>
</tr>
"; $juri=mysql_query("select penilaian.*, users.* from penilaian, users where penilaian.id_peserta='$_GET[id]' and users.username=penilaian.id_user");
while($juri2=mysql_fetch_array($juri)){
echo"

"; }
?>
  </tbody>
</table>
<br>
<br>
<div style="text-align: right;">Kalawat, 06 Maret 2020<br>
</div>
<div style="text-align: center;"><br>
</div>
<table style="text-align: left; width: 1000px;" border="0"
 cellpadding="2" cellspacing="2">
  <tbody>
    <tr>
      <td style="text-align: center; width: 485px;">Panitia Pemilihan Remaja Teladan GMIM Wilayah Kalawat I<br>
      <br>
      <br>
      <br>
      <span style="text-decoration: underline;">Michelle Pinontoan</span><br>
Ketua </td>
      <td style="text-align: center; width: 495px;">Komisi Pelayanan Remaja Wilayah Kalawat I<br>
      <br>
      <br>
      <br>
      <span style="text-decoration: underline;">Pnt. Meilany Mongilala, S.T.</span><br>
Ketua</td>
    </tr>
    <tr>
      <td style="text-align: center; width: 485px;"></td>
      <td style="text-align: center; width: 495px;"></td>
    </tr>
    
  </tbody>
</table>
<br>
<br>
</body>
</html>
