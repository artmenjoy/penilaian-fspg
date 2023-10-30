<?php
session_start();
if (empty($_SESSION['namauser']) AND empty($_SESSION['passuser'])){
	header('location:index.php');
}else{
	//include "config/koneksi.php";
	include "config/library.php";
	include "config/teslog.php";
	include "config/fungsi_indotgl.php";
	include "config/fungsi_combobox.php";
	include "config/class_paging.php";
	include "config/timer.php";
	
	if (!login_check()) { ?>
		<script language='javascript'>document.location.href='logout.php';</script>
		<? exit(0);	
	}
	
	$mod = $_GET['module'];
	if (!file_exists("modul/mod_$mod/$mod.php")){ ?>
		<div id="page-wrapper">
            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">404 <small>Modul tidak ditemukan</small></h1>
					<ul class="breadcrumb">
						<li><a href="media.php?module=home">Beranda</a></li>
						<li class="active">Error</li>
					</ul>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
				</div>
			</div>
		</div>
	<?php
	}else{
		include "modul/mod_$mod/$mod.php";
	}
}
?>