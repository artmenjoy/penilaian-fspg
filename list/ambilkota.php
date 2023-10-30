<?php
include "../config/koneksi.php";

$kabkota = $_GET['kabkota'];
$kota = mysql_query("SELECT id_kecamatan,kecamatan FROM kecamatan WHERE id_kabkota='$kabkota' order by kecamatan");
echo "<option value=''>-- Pilih Kecamatan --</option>";
while($k = mysql_fetch_array($kota)){
    echo "<option value=\"".$k['id_kecamatan']."\">".$k['kecamatan']."</option>\n";
}
?>
