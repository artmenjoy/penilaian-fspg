<?php
include "../../config/koneksi.php";

$tgl=date("H-i-s");
$table_name = "tulisan";
$backup_file  = "H:\/tulisan-$tgl.sql";
$sql = "SELECT * INTO OUTFILE '$backup_file' FROM $table_name";

mysql_select_db('cca');
$retval = mysql_query( $sql );
if(! $retval )
{
  die('Could not take data backup: ' . mysql_error());
}

?>