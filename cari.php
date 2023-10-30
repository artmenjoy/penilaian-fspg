<?php
include"config/koneksi.php";
if(isset($_POST['queryString'])) {
			$queryString = mysql_real_escape_string($_POST['queryString']);
			
			// Apakah string yang dimasukkan lebih besar dari 0?
			if(strlen($queryString) >3) {
				$query=mysql_query("SELECT jemaat
									FROM jemaat 
									WHERE jemaat LIKE '%" . $queryString . "%' ORDER BY jemaat"); //batasi hasil pencarian hanya 8 user
				$cek=mysql_num_rows($query);
				if($cek!=0) {
					// Jika query berhasil maka ambil data user
					while ($row = mysql_fetch_array($query)) {
	         			echo"$row[jemaat] <br>";
	         		}

				} else {
					echo"tidak ada";
				}
				echo"</table>";
			} 
		} 

?>