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
					<h3 class="page-header">Manajemen Rekap Nilai</h3>
				</div>
			</div>

			<? include "list/alert.php";

			switch ($_GET[act]) {
				default:
			?>

					<div class='row'>
						<div class='col-lg-12'>

							<? if ($cekcrud['lihat'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>
								<!-- <p><a href='?module=<?= $mod; ?>&act=rekapnilaiall' class='btn btn-primary'><span>Rekap Nilai All</span></a></p> -->
							<? } ?>

							<div class='panel panel-default'>
								<div class='panel-heading'>Rekap Nilai</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables">
											<thead>
												<tr>
													<th>No</th>
													<th>Kategori Nilai</th>
													<th>Persentase Nilai</th>
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?
												$no = 1;
												$tampil = mysql_query("SELECT * FROM kategorinilai ORDER BY kategorinilai ASC");
												while ($r = mysql_fetch_array($tampil)) {
													$idmod = "id_" . $mod;
													echo "<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[kategorinilai]</td>
											<td>$r[persentasenilai]</td>
											<td>";
													if ($cekcrud['lihat'] == 'y' or $_SESSION[leveluser] == 'admin') {
														echo "<a href='?module=$mod&act=lihatpeserta&id=$r[id_kategorinilai]' title='Lihat'>Lihat Peserta</a> ";
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
					break;

				case "lihatpeserta":
				?>
					<div class='row'>
						<div class='col-lg-12'>

							<? if ($cekcrud['lihat'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>
							<? }
							$kategorinilai = mysql_query("select * from kategorinilai where id_kategorinilai='$_GET[id]'");
							$kategorinilai2 = mysql_fetch_array($kategorinilai);
							?>

							<div class='panel panel-default'>
								<div class='panel-heading'>Rekap Nilai <?= $kategorinilai2[kategorinilai] ?></div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables">
											<thead>
												<tr>
													<th style= "width:50px">Nomor Urut</th>

													<th>Peserta</th>
													<!-- <th>Jemaat</th> -->
													<!-- <th>Wilayah</th> -->
													<th>Wilayah</th>
													<?
													$juri = mysql_query("select users.namalengkap from users,penilaian where penilaian.id_user=users.username and penilaian.id_kategorinilai='$_GET[id]' group by users.namalengkap");
													while ($juri2 = mysql_fetch_array($juri)) {
														echo "<th>Nilai By $juri2[namalengkap]</th>
											";
													}
													?>
													<th>Total</th>
												</tr>
											</thead>
											<tbody>
												<?
												$no = 1;
												$tampil = mysql_query("SELECT peserta.*, rayon.rayon FROM peserta,rayon where peserta.id_rayon=rayon.id_rayon order by peserta.peserta");
												while ($r = mysql_fetch_array($tampil)) {
													$idmod = "id_" . $mod;
													echo "<tr class='gradeX'>
											<td>$r[nomortalent]</td>
											<td>$r[peserta]</td>
											<td>$r[wilayah]</td>
											
											
											";
													$juri3 = mysql_query("select users.namalengkap, users.username from users,penilaian where penilaian.id_user=users.username and penilaian.id_kategorinilai='$_GET[id]' group by users.namalengkap");
													while ($juri4 = mysql_fetch_array($juri3)) {
														$ceknilai = mysql_query("select * from penilaian where id_user='$juri4[username]' and id_peserta='$r[id_peserta]' and id_kategorinilai='$_GET[id]'");
														$ceknilai2 = mysql_fetch_array($ceknilai);
														echo "<td>$ceknilai2[penilaian]</td>
												";
													}
													$totalavg = mysql_query("select avg(penilaian) as rata from penilaian where id_peserta='$r[id_peserta]' and id_kategorinilai='$_GET[id]'");
													$totalavg2 = mysql_fetch_array($totalavg);
													$bulat = round($totalavg2[rata], 2);
													echo "<td>$bulat</td>";
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
					break;

				case "rekapnilaiall":
				?>
					<div class='row'>
						<div class='col-lg-12'>

							<? if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>
							<? }
							?>

							<div class='panel panel-default'>
								<div class='panel-heading'>Rekap Nilai All</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables">
											<thead>
												<tr>
													<th>No</th>
													<th>Peserta</th>
													<th>Jemaat</th>
													<!-- <th>Wilayah</th> -->
													<!-- <th>Pria/Wanita</th> -->
													<?
													$kategori = mysql_query("select * from kategorinilai");
													while ($kategori2 = mysql_fetch_array($kategori)) {
														echo "<th>$kategori2[kategorinilai]</th>";
													}
													?>
													<th>Total Nilai</th>
													<th>Cetak</th>
												</tr>
											</thead>
											<tbody>
												<?
												$no = 1;

												$tampil = mysql_query("SELECT peserta.*, rayon.rayon FROM peserta,rayon where peserta.id_rayon=rayon.id_rayon order by peserta.peserta");
												while ($r = mysql_fetch_array($tampil)) {
													$idmod = "id_" . $mod;

													echo "<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[peserta]</td>
											<td>$r[jemaat]</td>
									
											";
													$totalnilai = 0;
													$kategori3 = mysql_query("select * from kategorinilai");
													while ($kategori4 = mysql_fetch_array($kategori3)) {
														$ceknilai = mysql_query("select avg(penilaian) as rata from penilaian where id_peserta='$r[id_peserta]' and id_kategorinilai='$kategori4[id_kategorinilai]'");
														$ceknilai2 = mysql_fetch_array($ceknilai);

														$last1 = ($ceknilai2['rata'] / $kategori4['nilaimaksimal']) * 100;
														$last = $last1 * ($kategori4['persentasenilai'] / 100);

														$totalnilai = $totalnilai + $last;
														$bulat1 = round($last, 3);
														$katnilai = round($ceknilai2['rata'], 2);
														$persenkat = round($kategori4['persentasenilai'], 2);
														echo "<td>$katnilai x $persenkat % = $bulat1 </td>";
													}
													$bulat2 = round($totalnilai, 3);
													echo "<td>$bulat2</td>
											<td><a href='/penjurian/cetak.php?id=$r[id_peserta]' title='Cetak' class='with-tip'>Cetak</td>";
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
					break;


				case "tambah$mod":
					if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>

						<div class='row'>
							<div class='col-lg-12'>

								<div class='panel panel-default'>
									<div class='panel-heading'>Tambah Rekap Nilai</div>
									<div class="panel-body">
										<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=input"; ?>'>
											<div class="form-group">
												<label>Rekap Nilai :</label>
												<input class="form-control" type=text name='<?= $mod ?>' id='<?= $mod; ?>' placeholder="<?= $mod; ?>" required>
											</div>

											<div class="form-group">
												<label>Persentase Nilai :</label>
												<input class="form-control" type=text name='persentasenilai' id='persentasenilai' placeholder="Persentase Nilai" required>
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
					?>
						<div class='row'>
							<div class='col-lg-12'>

								<div class='panel panel-default'>
									<div class='panel-heading'>Edit Rekap Nilai</div>
									<div class="panel-body">
										<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=update"; ?>' onsubmit='return validateForm()'>
											<input type=hidden name=id value='<? echo "$r[$idmod]"; ?>'>
											<div class="form-group">
												<label>Rekap Nilai :</label>
												<input class="form-control" type=text name='<?= $mod; ?>' id='<?= $mod; ?>' value='<?= $r[kategorinilai] ?>' required>
											</div>
											<div class="form-group">
												<label>Persentase Nilai :</label>
												<input class="form-control" type=text name='persentasenilai' id='persentasenilai' value='<?= $r[persentasenilai] ?>' required>
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