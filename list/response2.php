<?php
include "../../config/koneksi.php";
include "mp3file.php";

$min=mysql_query("select min(id_wawancara) as min from wawancara where sudah=''");
$min2=mysql_fetch_array($min);


$cekurut=mysql_query("select * from wawancara where id_wawancara='$min2[min]'");
$cekurut2=mysql_fetch_array($cekurut);
$cekurut3=mysql_num_rows($cekurut);

if($cekurut3 > 0){
/*
$mp3file = new MP3File("./audio/$cekurut2[id_pendaftaran].mp3");
$duration1 = $mp3file->getDurationEstimate();
$panjang=($duration1*1000)+3000;
*/
echo"  

<embed id='track' src='./list/panggilan.wav' autostart='true' loop='false' width='0' and height='0'>

<audio controls='controls autoplay='autoplay' controls='' onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, 3000)' width='0' height='0'>
    <source src='./list/audio/$cekurut2[id_peserta].mp3' type='audio/mp3' />
</audio>
";
/*

<audio controls='controls autoplay='autoplay' controls='' onloadeddata='var audioPlayer = this; setTimeout(function() { audioPlayer.play(); }, $panjang)' width='0' height='0'>
    <source src='./list/audio/juri/$cekurut2[username].mp3' type='audio/mp3' />
</audio>

*/
mysql_query("UPDATE wawancara SET sudah = 'Y' WHERE id_wawancara = '$min2[min]'");
echo"Urut : $cekurut3";
}
?>