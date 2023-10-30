<?php
session_start();
error_reporting(0);

//fungsi cek akses user
function user_akses($mod, $id)
{
	$link = "?module=" . $mod;
	$cek = mysql_num_rows(mysql_query("SELECT * FROM modul,grupakses,aksescrud,users WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and modul.id_modul=aksescrud.id_modul and users.id_session='$id' AND modul.link='$link' and aksescrud.lihat='y'"));
	return $cek;
}

//fungsi cek akses user mode CRUD
function user_akses_crud($mod, $id)
{
	$link = "?module=" . $mod;
	$cekcrud = mysql_fetch_array(mysql_query("SELECT aksescrud.lihat, aksescrud.isi, aksescrud.ubah, aksescrud.hapus FROM modul,grupakses,aksescrud,users WHERE users.id_grupakses=grupakses.id_grupakses and grupakses.id_grupakses=aksescrud.id_grupakses and modul.id_modul=aksescrud.id_modul and users.id_session='$id' AND modul.link='$link'"));
	return $cekcrud;
}

//fungsi cek akses menu
function umenu_akses($link, $id)
{
	$cek = mysql_num_rows(mysql_query("SELECT * FROM modul,usersmodul WHERE modul.id_modul=usersmodul.id_modul AND usersmodul.id_session='$id' AND modul.link='$link'"));
	return $cek;
}

//fungsi redirect
function akses_salah()
{
	$pesan = "<center>Maaf Anda tidak berhak mengakses halaman ini</center>";
	$pesan .= "<meta http-equiv='refresh' content='2;url=media.php?mod=home'>";
	return $pesan;
}

function rupiah($nilai, $pecahan = 0)
{
	return number_format($nilai, $pecahan, ',', '.');
}


if (empty($_SESSION['namauser']) and empty($_SESSION['passuser'])) {
	header('location:index.php');
} else {
?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="">
		<title>Sistem Penilaian FSPG</title>
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
		<link href="css/plugins/dataTables.bootstrap.css" rel="stylesheet">
		<link href="css/sb-admin-2.css" rel="stylesheet">
		<link href="css/datepicker.css" rel="stylesheet">
		<link href="font-awesome-4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">
		<style>
			label.error {
				display: block;
				padding-left: 10px;
				font-size: 90%;
				color: red
			}
		</style>

		<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
		<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
		<!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

		<script src="js/jquery-1.11.0.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<script src="js/plugins/metisMenu/metisMenu.min.js"></script>
		<script src="js/plugins/dataTables/jquery.dataTables.js"></script>
		<script src="js/plugins/dataTables/dataTables.bootstrap.js"></script>
		<script src="js/sb-admin-2.js"></script>
		<script src="js/jquery.validate.min.js"></script>
		<script src="js/jquery.searchit.js"></script>
		<script src="js/bootstrap-datepicker.js"></script>

		<script>
			$(document).ready(function() {
				$('#dataTables').dataTable({
					"oLanguage": {
						"sLengthMenu": "Tampilkan _MENU_ data per halaman",
						"sSearch": "Pencarian: ",
						"sZeroRecords": "Maaf, tidak ada data yang ditemukan",
						"sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
						"sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
						"sInfoFiltered": "(di filter dari _MAX_ total data)",
						"oPaginate": {
							"sFirst": "Awal",
							"sLast": "Akhir",
							"sPrevious": "<",
							"sNext": ">"
						}
					},
					"sPaginationType": "full_numbers"
				});
				$('.dataTables').dataTable({
					"oLanguage": {
						"sLengthMenu": "Tampilkan _MENU_ data per halaman",
						"sSearch": "Pencarian: ",
						"sZeroRecords": "Maaf, tidak ada data yang ditemukan",
						"sInfo": "Menampilkan _START_ s/d _END_ dari _TOTAL_ data",
						"sInfoEmpty": "Menampilkan 0 s/d 0 dari 0 data",
						"sInfoFiltered": "(di filter dari _MAX_ total data)",
						"oPaginate": {
							"sFirst": "Awal",
							"sLast": "Akhir",
							"sPrevious": "<",
							"sNext": ">"
						}
					},
					"sPaginationType": "full_numbers"
				});
			});
		</script>

		<script type="text/javascript">
			var otomatis = setInterval(
				function() {
					$('#responsecontainer').load('./list/response.php').fadeIn("slow");
				}, 7000);
		</script>

		<script type="text/javascript">
			var otomatis2 = setInterval(
				function() {
					$('#responsecontainer2').load('./list/response2.php').fadeIn("slow");
				}, 15000);
		</script>

		<script type="text/javascript">
			var otomatis3 = setInterval(
				function() {
					$('#responsecontainer3').load('./list/response3.php').fadeIn("slow");
				}, 300000);
		</script>

	</head>

	<body>
		<div id="wrapper">
			<!-- Navigation -->
			<nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="index.html">Sistem Penilaian - Welcome <?= $_SESSION[namalengkap] ?></a>
				</div>
				<!-- /.navbar-header -->
				<ul class="nav navbar-top-links navbar-right">
					<? if ($_SESSION[leveluser] == 'userjemaat') { ?>
						<li><a href="#"><i class="fa fa-info-circle fa-fw"></i> <?= $_SESSION[jemaat] ?></a></li>
					<? } ?>
					<li class="dropdown">
						<a class="dropdown-toggle" data-toggle="dropdown" href="#">
							<i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
						</a>
						<ul class="dropdown-menu dropdown-user">
							<li><a href="?module=userprofil"><i class="fa fa-user fa-fw"></i> <?= $_SESSION[namalengkap] ?></a></li>
							<li><a href="?module=setting"><i class="fa fa-gear fa-fw"></i> Settings</a></li>
							<li class="divider"></li>
							<li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a></li>
						</ul>
					</li>
				</ul>
				<!-- /.navbar-top-links -->

				<div class="navbar-default sidebar" role="navigation">
					<div class="sidebar-nav navbar-collapse">
						<div align="center">
							<img class="profile-img" src="d.jpg" alt="">
						</div>
						<? include "menu.php"; ?>

					</div>
					<!-- /.sidebar-collapse -->
				</div>
				<!-- /.navbar-static-side -->
			</nav>

			<!-- Page Content -->
			<? include "content.php"; ?>

		</div>
		<!-- /#wrapper -->



	</body>

	</html>

<?php
}
?>