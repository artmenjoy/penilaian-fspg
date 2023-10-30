<?php
include "../config/koneksi.php";

 $edit=mysql_query("SELECT pelatihananggota.scansertifikat, pelatihananggota.tipefile 
 FROM pelatihananggota, anggota 
 WHERE pelatihananggota.id_anggota=anggota.id_anggota 
 and pelatihananggota.id_pelatihananggota='18258873'");
 $r=mysql_fetch_array($edit);

      $content=$r[0];
      $type=$r[1];
      header("Content-type: $type"); 
      echo "$content";

?>