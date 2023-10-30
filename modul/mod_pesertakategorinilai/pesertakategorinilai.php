<script>
function confirmdelete(delUrl) {
   if (confirm("Anda yakin ingin menghapus?")) {
      document.location = delUrl;
   }
}
</script>

<?php
session_start();
if (empty($_SESSION['username']) AND empty($_SESSION['passuser'])){
	header('location:index.php');
}else{

//cek hak akses user
$cek=user_akses($_GET[module],$_SESSION[sessid]);
if($cek==1 OR $_SESSION[leveluser]=='admin'){
	$cekcrud=user_akses_crud($_GET[module],$_SESSION[sessid]);
	$aksi="modul/mod_$mod/aksi_$mod.php";
	?>
	
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Manajemen Peserta Kategori Nilai</h3>
        </div>
	</div>
	
		<? include "list/alert.php";
	
	switch($_GET[act]){
	default: 
	?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($cekcrud['lihat']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan Peserta Kategori Nilai</span></a></p>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Peserta Kategori Nilai</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Peserta</th>
									<th>Kategori Nilai</th>
									<th>Jumlah Kategori</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("SELECT peserta,id_peserta FROM peserta where id_peserta in(select id_peserta from pesertakategorinilai group by id_peserta)");
								while($r=mysql_fetch_array($tampil)){
									$idmod="id_".$mod;
									$stringcat="";
									$jumstringcat=0;
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[peserta]</td>";
											$kat=mysql_query("select kategorinilai.kategorinilai from kategorinilai,pesertakategorinilai where kategorinilai.id_kategorinilai=pesertakategorinilai.id_kategorinilai and pesertakategorinilai.id_peserta='$r[id_peserta]'");
											while($kat2=mysql_fetch_array($kat)){
												$stringcat="$stringcat $kat2[kategorinilai],";
												$jumstringcat++;
											}
											echo"
											<td>$stringcat</td>
											<td>$jumstringcat</td>
											
											<td>";
											if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href='?module=$mod&act=edit$mod&id=$r[id_peserta]' title='Edit'><i class='fa fa-wrench'></i></a> ";
											}
											if($cekcrud['hapus']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$r[id_peserta]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
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
	if($cekcrud['isi']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Tambah Peserta Kategori Nilai</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Peserta :</label>
							<select name='id_peserta' class="form-control" required>
							<option>-Pilih-Peserta-</option>
							<?
							$tampilpeserta=mysql_query("SELECT * FROM peserta where id_peserta not in(select id_peserta from pesertakategorinilai group by id_peserta)");
							while($peserta=mysql_fetch_array($tampilpeserta)){
								echo "<option value=$peserta[id_peserta]>$peserta[peserta]</option>"; 
							}
							?>
							</select>
						</div>

						<div class="form-group">
							<?
								$tampilkategorinilai=mysql_query("SELECT * FROM kategorinilai");
								while($kategorinilai=mysql_fetch_array($tampilkategorinilai)){
								echo "
									<label>$kategorinilai[kategorinilai] :</label><input type='checkbox' name='$kategorinilai[id_kategorinilai]' value='$kategorinilai[id_kategorinilai]' checked> 
								"; 
								}
							?>
                            
                        </div>
						
						<button type="submit" class="btn btn-default">Simpan</button>
						<a href='?module=<?=$mod;?>'<button type="reset" class="btn btn-default">Batal</button></a>
					</form>
				</div>
			</div>
		</div>
	</div>
	
	<?
	}
	break;
	
	case "edit$mod":
	if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
	$edit=mysql_query("SELECT * FROM $mod WHERE id_$mod='$_GET[id]'");
	$r=mysql_fetch_array($edit);
	$idmod="id_".$mod;
	?>
	<div class='row'>
		<div class='col-lg-12'>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Edit Peserta Kategori Nilai</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>'>
					
						<div class="form-group">
							<label>Peserta :</label>
							<select name='id_peserta' class="form-control" required>
							<?
							$tampilpeserta=mysql_query("SELECT * FROM peserta where id_peserta='$_GET[id]'");
							while($peserta=mysql_fetch_array($tampilpeserta)){
								echo "<option value=$peserta[id_peserta]>$peserta[peserta]</option>"; 
							}
							?>
							</select>
						</div>

						<div class="form-group">
							<?
								$tampilkategorinilai=mysql_query("SELECT * FROM kategorinilai");
								while($kategorinilai=mysql_fetch_array($tampilkategorinilai)){
									$cekkategori=mysql_query("select * from pesertakategorinilai where id_peserta='$_GET[id]' and id_kategorinilai='$kategorinilai[id_kategorinilai]'");
									$cekkategori2=mysql_num_rows($cekkategori);
									if($cekkategori2 > 0){

										echo "
											<label>$kategorinilai[kategorinilai] :</label><input type='checkbox' name='$kategorinilai[id_kategorinilai]' value='$kategorinilai[id_kategorinilai]' checked> 
										";
									}
									else{
										echo "
											<label>$kategorinilai[kategorinilai] :</label><input type='checkbox' name='$kategorinilai[id_kategorinilai]' value='$kategorinilai[id_kategorinilai]'> 
										";
									} 
								}
							?>
                            
                        </div>
						
						<button type="submit" class="btn btn-default">Simpan</button>
						<a href='?module=<?=$mod;?>'<button type="reset" class="btn btn-default">Batal</button></a>
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
}else{
	echo akses_salah();
}
}
?>