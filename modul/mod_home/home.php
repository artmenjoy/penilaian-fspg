<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	header('location:index.php');
} else {

	//cek hak akses user
	$cek = user_akses($_GET[module], $_SESSION[sessid]);
	if ($cek == 1 or $_SESSION[leveluser] == 'admin') {
?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header"><i class='fa fa-home'></i>Sistem Penilaian - FSPG</h3>
				</div>
			</div>
			<?

			switch ($_GET[act]) {

				default:
					if ($cek == 1 or $_SESSION[leveluser] == 'admin') {
			?>
						<div class="row">

							<!-- <img class="profile-img" style="width:100%" src="bg-fspg-wide.jpg" alt=""> -->
						</div>



			<?
					}

					break; // end of default

			} // end of switch($[act])
			?>
		</div>

<?
	} else {
		echo akses_salah();
	}
}
?>