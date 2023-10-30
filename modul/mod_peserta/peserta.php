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
					<h3 class="page-header">Manajemen Peserta</h3>
				</div>
			</div>

			<? include "list/alert.php";

			switch ($_GET[act]) {
				default:
			?>

					<div class='row'>
						<div class='col-lg-12'>

							<? if ($cekcrud['lihat'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>
								<p><a href='?module=<?= $mod; ?>&act=tambah<?= $mod; ?>' class='btn btn-primary'><span>Tambahkan Peserta</span></a></p>
							<? } ?>

							<div class='panel panel-default'>
								<div class='panel-heading'>Peserta</div>
								<div class="panel-body">
									<div class="table-responsive">
										<table class="table table-striped table-bordered table-hover" id="dataTables">
											<thead>
												<tr>
													<!-- tampilkan -->
													<th>No Tampil</th>
													<th>Peserta</th>

													<th>Jemaat</th>
													<!-- <th>Kelamin</th> -->

													
													<th>Aksi</th>
												</tr>
											</thead>
											<tbody>
												<?
												$no = 1;
												$tampil = mysql_query("SELECT peserta.*, rayon.rayon FROM peserta,rayon where peserta.id_rayon=rayon.id_rayon ORDER BY nomortalent ASC");
												while ($r = mysql_fetch_array($tampil)) {
													$idmod = "id_" . $mod;
													echo "<tr class='gradeX'>
											<td>$r[nomortalent]</td>
											<td>$r[$mod]</td>
											
											<td>$r[jemaat]</td>
											
											
											<td>";
													if ($cekcrud['ubah'] == 'y' or $_SESSION[leveluser] == 'admin') {
														echo "<a href='?module=$mod&act=edit$mod&id=$r[$idmod]' title='Edit'><i class='fa fa-wrench'></i></a> ";
													}
													if ($cekcrud['hapus'] == 'y' or $_SESSION[leveluser] == 'admin') {
														echo "<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$r[$idmod]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
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

				case "tambah$mod":
					if ($cekcrud['isi'] == 'y' or $_SESSION[leveluser] == 'admin') { ?>

						<div class='row'>
							<div class='col-lg-12'>

								<div class='panel panel-default'>
									<div class='panel-heading'>Tambah Peserta</div>
									<div class="panel-body">
										<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=input"; ?>'>
											<div class="form-group">
												<label>Peserta :</label>
												<input class="form-control" type=text name='<?= $mod ?>' id='<?= $mod; ?>' placeholder="<?= $mod; ?>" required>
											</div>
											<div class="form-group">
												<input type="hidden" name="kelamin" value="Pria" checked>



											</div>
											<div class="form-group">
												<label>Jemaat :</label>
												<input class="form-control" type=text name='jemaat' id='jemaat' placeholder="Jemaat" required>

												<div class="form-group">
													<label>Wilayah :</label>
													<select name='id_rayon' class="form-control" required>
														<option>-Pilih-Wilayah-</option>
														<?
														$tampilrayon = mysql_query("SELECT * FROM rayon");
														while ($rayon = mysql_fetch_array($tampilrayon)) {
															echo "<option value=$rayon[id_rayon]>$rayon[rayon]</option>";
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Nomor Tampil :</label>
													<input class="form-control" type=text name='nomortalent' placeholder="nomortalent" required>
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
									<div class='panel-heading'>Edit Peserta</div>
									<div class="panel-body">
										<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<? echo "$aksi?module=$mod&act=update"; ?>' onsubmit='return validateForm()'>
											<input type=hidden name=id value='<? echo "$r[$idmod]"; ?>'>
											<div class="form-group">
												<label>Peserta :</label>
												<input class="form-control" type=text name='<?= $mod; ?>' id='<?= $mod; ?>' value='<?= $r[$mod] ?>' required>
											</div>
											<div class="form-group">
												<!-- <label class="control-label">Kelamin :</label>
												<div class="form-control">
													<?php
													if ($r['kelamin'] == 'Pria') {
													?>
														<label class="radio-inline">
															<input type="radio" name="kelamin" value="Pria" checked>Pria
														</label>
														<label class="radio-inline">
															<input type="radio" name="kelamin" value="Wanita">Wanita
														</label>
													<?php
													} else {
													?>

														<label class="radio-inline">
															<input type="radio" name="kelamin" value="Pria">Pria
														</label>
														<label class="radio-inline">
															<input type="radio" name="kelamin" value="Wanita" checked>Wanita
														</label>
													<?php
													}
													?>
												</div> -->
											</div>
											<div class="form-group">
												<label>Jemaat :</label>
												<input class="form-control" type=text name='jemaat' id='jemaat' placeholder="Jemaat" value='<?= $r[jemaat] ?>' required>


												<div class="form-group">
													<label>Wilayah :</label>
													<select name='id_rayon' class="form-control" required>
														<option>-Pilih-Wilayah-</option>
														<?
														$tampilrayon = mysql_query("SELECT * FROM rayon");
														while ($rayon = mysql_fetch_array($tampilrayon)) {
															if ($r['id_rayon'] == $rayon['id_rayon']) {
																echo "<option value=$rayon[id_rayon] selected>$rayon[rayon]</option>";
															} else {
																echo "<option value=$rayon[id_rayon]>$rayon[rayon]</option>";
															}
														}
														?>
													</select>
												</div>
												<div class="form-group">
													<label>Nomor Tampil :</label>
													<input class="form-control" type=text name='nomortalent' value='<?= $r[nomortalent] ?>' required>

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