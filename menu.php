<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:index.php');
}else{
	include 'config/koneksi.php';

	$mod = $_GET['module'];
	  
	echo "<ul class='nav' id='side-menu'>";
		$menu="";
		if($_SESSION['leveluser']=='admin'){
			$parent=mysql_query("select * from parent order by urutan asc");
		}
		else{
			$parent=mysql_query("select parent.*, grupakses.id_grupakses from parent,users, grupakses, aksescrud, modul where
		 	users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and modul.id_modul=aksescrud.id_modul and modul.id_parent=parent.id_parent
		 	and users.username='$_SESSION[namauser]' order by parent.urutan asc");
		}
		while($parent2=mysql_fetch_array($parent)){
			if($menu!=$parent2['parent']){ //kalo nda ada ini menu mo ta ulang-ulang
				$menu="$parent2[parent]";
				$cekjumlah=mysql_query("select * from modul where id_parent='$parent2[id_parent]'");
				$cekjumlah2=mysql_num_rows($cekjumlah);
				//kalo cuma 1 dpe subbagian dari parent
				if($cekjumlah2 < 2){
					$cekjumlah3=mysql_fetch_array($cekjumlah);
					echo"
						<li>
							<a href='$cekjumlah3[link]' class='$active$parent2[parent]'><i class='$parent2[icon]'></i> $parent2[parent]</a>
						</li>
					";
				}
				else{
					echo"
						<li class='$active$parent2[parent]'>
            				<a href='#'><i class='$parent2[icon]'></i> $parent2[parent]<span class='fa arrow'></span></a>
            				<ul class='nav nav-second-level'>";
            					if($_SESSION[leveluser]=='admin'){
            						$subparent=mysql_query("select * from modul where id_parent='$parent2[id_parent]' order by urutan");
            					}
            					else{
            						$subparent=mysql_query("select modul.* from modul, aksescrud where aksescrud.id_modul=modul.id_modul and modul.id_parent='$parent2[id_parent]' and aksescrud.id_grupakses='$parent2[id_grupakses]' order by modul.urutan");
            					}
            					while($subparent2=mysql_fetch_array($subparent)){
            						echo"
            							<li><a class='$activesub$subparent2[modul]' href='$subparent2[link]'><i class='$subparent2[icon]'></i> $subparent2[modul]</a></li>
                					";
                				}
            					echo"
            				</ul>
        				</li>
        
					";

				}
			}
		
		}
	echo"
	</ul>";

}
?>