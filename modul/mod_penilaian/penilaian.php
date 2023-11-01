<script>
	function confirmdelete(delUrl) {
		if (confirm("Anda yakin ingin menghapus?")) {
			document.location = delUrl;
		}
	}
</script>

<?php
session_start();
if (empty($_SESSION['username']) and empty($_SESSION['passuser'])) {
	header('location:index.php');
} else {

	//cek hak akses user
	$cek = user_akses($_GET[module], $_SESSION[sessid]);
	if ($cek == 1 or $_SESSION[leveluser] == 'admin') {
		$cekcrud = user_akses_crud($_GET[module], $_SESSION[sessid]);
		$aksi = "modul/mod_$mod/aksi_$mod.php";
?>

		<div id="page-wrapper">
			<div class="row">
				<div class="col-lg-12">
					<h3 class="page-header">Manajemen Penilaian</h3>
				</div>
			</div>

			<? include "list/alert.php";

			switch ($_GET[act]) {
				default:
			?>

					<div class='row'>
						<div class='col-lg-12'>

							<? if ($cekcrud['lihat'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>

								<div class='panel panel-default'>
									<div class='panel-heading'>Penilaian</div>
									<div class="panel-body">
										<div class="table-responsive">
											<table class="table table-striped table-bordered table-hover" id="dataTables">
												<thead>
													<tr>
														<th>No</th>
														<th>Kategori Nilai</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
													<?
													$no = 1;
													$tampil = mysql_query("SELECT kategorinilai.kategorinilai,kategorinilai.id_kategorinilai FROM userkategorinilai,kategorinilai, users where userkategorinilai.id_kategorinilai=kategorinilai.id_kategorinilai and userkategorinilai.id_user=users.username and users.username='$_SESSION[namauser]'");
													while ($r = mysql_fetch_array($tampil)) {
														$idmod = "id_" . $mod;
														echo "<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[kategorinilai]</td>
											<td>";
														if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') {
															echo "<a href='?module=$mod&act=peserta&id_kategorinilai=$r[id_kategorinilai]' title='Nilai'>Pilih Kategori</a> ";
														}

														$no++;
													}
													?>
												</tbody>
											</table>
										</div>
									</div>
								</div>
						</div>
					</div>
				<?
							}
							break;

						case "peserta":
							mysql_query("DELETE from wawancara where username='$_SESSION[namauser]'");
				?>
				<div class='row'>
					<div class='col-lg-12'>

						<? if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') {
								$kategorinilai = mysql_query("select * from kategorinilai where id_kategorinilai='$_GET[id_kategorinilai]'");
								$kategorinilai2 = mysql_fetch_array($kategorinilai);
						?>

							<div class='panel panel-default'>
								<div class='panel-heading'>Penilaian Peserta Kategori Nilai : <?= $kategorinilai2['kategorinilai'] ?></div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables">
											<thead>
												<tr>

													<th style="width:50px">Nomor Urut</th>
													<th>Jemaat</th>

													<th>Wilayah</th>
													<th>Nilai</th>
													<!-- <th>Catatan</th> -->
													<th>Penilaian</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?
												$no = 1;
												$tampil = mysql_query("SELECT peserta.*, rayon.rayon FROM peserta,rayon where peserta.id_rayon=rayon.id_rayon and peserta.id_peserta in(select id_peserta from pesertakategorinilai where id_kategorinilai='$_GET[id_kategorinilai]') ORDER BY peserta.nomortalent ASC");
												while ($r = mysql_fetch_array($tampil)) {
													$idmod = "id_" . $mod;
													echo "<tr class='gradeX'>
											<td>$r[nomortalent]</td>
											<td>$r[peserta]</td>
											
											<td>$r[wilayah]</td>
											
											";
													$nilainya = mysql_query("select * from penilaian where id_peserta='$r[id_peserta]' and id_kategorinilai='$_GET[id_kategorinilai]' and id_user='$_SESSION[namauser]'");
													$nilainya2 = mysql_fetch_array($nilainya);
													$nilainya3 = mysql_num_rows($nilainya);
													echo "
											<td>$nilainya2[penilaian]</td>
											
											<td>";
													$cekkategori = mysql_query("SELECT kategorinilai.kategorinilai,kategorinilai.id_kategorinilai FROM userkategorinilai,kategorinilai, users where userkategorinilai.id_kategorinilai=kategorinilai.id_kategorinilai and userkategorinilai.id_user=users.username and users.username='$_SESSION[namauser]' and kategorinilai.id_kategorinilai='$_GET[id_kategorinilai]'");
													$cekwawancara = mysql_num_rows(mysql_query("select * from wawancara where id_peserta='$r[id_peserta]'"));
													$cekkategori2 = mysql_num_rows($cekkategori);
													if ($cekkategori2 > 0 or $_SESSION[leveluser] == 'admin') {
														if ($nilainya3 < 1) {
															//if($cekwawancara < 1){
															echo "<a class='btn btn-success btn-xs'  href='?module=$mod&act=penilaianpeserta&id_kategorinilai=$_GET[id_kategorinilai]&id_peserta=$r[id_peserta]' title='Nilai'>Beri Nilai</a> ";
															//}
														}
													}
													echo "<td>";
													if ($nilainya3 > 0) {
														/**
												if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
													echo"<a href='?module=$mod&act=edit$mod&id=$nilainya2[id_penilaian]&id_peserta=$r[id_peserta]&id_kategorinilai=$_GET[id_kategorinilai]' title='Edit'><i class='fa fa-wrench'></i></a> ";
												}
														 **/
														if ($cekcrud['hapus'] == 'y' or $_SESSION[leveluser] == 'admin') {
															echo "<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$nilainya2[id_penilaian]&id_kategorinilai=$_GET[id_kategorinilai]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
														}
													}
													echo "</td>";
													$no++;
												}
												?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
					</div>
				</div>
			<?
							}


							break;

						case "penilaianpeserta":
							if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') {
								$kategorinilai = mysql_query("select * from kategorinilai where id_kategorinilai='$_GET[id_kategorinilai]'");
								$kategorinilai2 = mysql_fetch_array($kategorinilai);
								$peserta = mysql_query("select * from peserta where id_peserta='$_GET[id_peserta]'");
								$peserta2 = mysql_fetch_array($peserta);

								mysql_query("INSERT INTO `wawancara` (`id_peserta`, `username`, `sudah`) VALUES ('$_GET[id_peserta]', '$_SESSION[namauser]', 'n');");
			?>

				<div class='row'>
					<div class='col-lg-12'>

						<div class='panel panel-default'>
							<div class='panel-heading'>Beri nilai untuk NOMOR URUT <b><?=$peserta2['nomortalent']?></b>  Jemaat <b><?= $peserta2['peserta'] ?></b></div>
							<div class="panel-body">
								<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=input"; ?>'>
									<input type=hidden name=id_peserta value='<? echo "$_GET[id_peserta]"; ?>'>
									<input type=hidden name=id_kategorinilai value='<? echo "$_GET[id_kategorinilai]"; ?>'>
<p>Jika nilai pecahan pakai tanda titik (cth: 80.5)</p>
									<div class="form-group">
										<label>Penilaian A:</label>
										<input class="form-control" type=text name='content' id='penilaian' placeholder="Pecahan pakai Titik" required autocomplete="off"  >
									</div>
									<div class="form-group">
										<label>Penilaian B:</label>
										<input class="form-control" type=text name='correlation' id='penilaian' placeholder="Pecahan pakai Titik" required autocomplete="off">
									</div>
									<div class="form-group">
										<label>Penilaian C:</label>
										<input class="form-control" type=text name='performance' id='penilaian' placeholder="Pecahan pakai Titik" required autocomplete="off">
									</div>


									<button type="submit" class="btn btn-default">Simpan</button>
									<a href='?module=<?= $mod; ?>' <button type="reset" class="btn btn-default">Batal</button></a>
								</form>
							</div>
						</div>
					</div>
				</div>

			<?
							}
							break;

						case "edit$mod":
							if ($cekcrud['ubah'] == 'y' or $_SESSION[leveluser] == 'admin') {
								$edit = mysql_query("SELECT * FROM $mod WHERE id_$mod='$_GET[id]'");
								$r = mysql_fetch_array($edit);
								$idmod = "id_" . $mod;
								$kategorinilai = mysql_query("select * from kategorinilai where id_kategorinilai='$_GET[id_kategorinilai]'");
								$kategorinilai2 = mysql_fetch_array($kategorinilai);
								$peserta = mysql_query("select * from peserta where id_peserta='$_GET[id_peserta]'");
								$peserta2 = mysql_fetch_array($peserta);


			?>
				<div class='row'>
					<div class='col-lg-12'>

						<div class='panel panel-default'>
							<div class='panel-heading'>Edit Penilaian Kategori <?= $kategorinilai2['kategorinilai'] ?> Untuk Peserta <?= $peserta2['peserta'] ?></div>
							<div class="panel-body">
								<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=update"; ?>' onsubmit='return validateForm()'>
									<input type=hidden name=id value='<? echo "$_GET[id]"; ?>'>
									<input type=hidden name=id_peserta value='<? echo "$_GET[id_peserta]"; ?>'>
									<input type=hidden name=id_kategorinilai value='<? echo "$_GET[id_kategorinilai]"; ?>'>

									<div class="form-group">
										<label>Penilaian :</label>
										<input class="form-control" type=text name='penilaian' id='penilaian' placeholder="Nilai Peserta" value='<?= $r[penilaian] ?>' required>
									</div>
									<div class="form-group">
										<label>Catatan :</label>
										<input class="form-control" type=text name='catatan' id='catatan' placeholder="Catatan" value='<?= $r[catatan] ?>'>
									</div>

									<button type="submit" class="btn btn-default">Simpan</button>
									<a href='?module=<?= $mod; ?>' <button type="reset" class="btn btn-default">Batal</button></a>
								</form>
							</div>
						</div>
					</div>
				</div>
			<?
							}
							break
			?>
		</div>

<?
					}
				} else {
					echo akses_salah();
				}
			}
?>