<?php
include "../config/koneksi.php";

echo"<br><div style='text-align: center;'><span style='font-weight: bold;font-size:30px'>Wawancara Saat Ini</span</div><br><br>";

$juri=mysql_query("select users.*, users.* from users, userkategorinilai, kategorinilai where users.username=userkategorinilai.id_user and userkategorinilai.id_kategorinilai=kategorinilai.id_kategorinilai and kategorinilai.tampilkan='y' ");
  while($juri2=mysql_fetch_array($juri)){

  	$peserta=mysql_query("select peserta.peserta, peserta.id_peserta from peserta, wawancara where peserta.id_peserta=wawancara.id_peserta and wawancara.username='$juri2[username]'");
  	$peserta2=mysql_fetch_array($peserta);

  	$min=mysql_query("select * from wawancara where sudah!='Y' limit 1");
  	$min2=mysql_fetch_array($min);
  	$min3=mysql_num_rows($min);

    echo "
     

<table style='text-align: left; width: 100%;' border='0' cellpadding='2' cellspacing='2'>
<tbody>
<tr>
<td style='vertical-align: top; width: 253px; font-size: 40px;'>$juri2[namalengkap]<br>
</td>
<td style='vertical-align: top; width: 714px; font-size: 50px;'>: <span
style='font-weight: bold;'>$peserta2[peserta]</span><br>
</td>
</tr>
</tbody>
</table>

";
  }
?>