<?php
include "../config/koneksi.php";

$kecamatan = $_GET['kecamatan'];
$kec = mysql_query("SELECT id_kelurahan,kelurahan FROM kelurahan WHERE id_kecamatan='$kecamatan' order by kelurahan");
echo "<option value=''>-- Pilih Kelurahan --</option>";
while($k = mysql_fetch_array($kec)){
    echo "<option value=\"".$k['id_kelurahan']."\">".$k['kelurahan']."</option>\n";
}
?>