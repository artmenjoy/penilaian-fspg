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
            <h3 class="page-header">Manajemen Persahabatan</h3>
        </div>
	</div>
	
		<? include "list/alert.php";
	
	switch($_GET[act]){
	default: 
	?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($cekcrud['lihat']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan Persahabatan</span></a>
			<? } ?>
			
			<? if($cekcrud['lihat']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<a href='<? echo"$aksi?module=$mod&act=reset";?>' class='btn btn-primary'><span>Reset Persahabatan</span></a></p>
			<? } ?>

			<div class='panel panel-default'>
				<div class='panel-heading'>Persahabatan</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Jumlah</th>
									
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("select peserta.peserta, count(persahabatan.id_peserta) as tot from peserta, persahabatan where peserta.id_peserta=persahabatan.id_peserta group by persahabatan.id_peserta order by tot desc");
								while($r=mysql_fetch_array($tampil)){
									$idmod="id_".$mod;
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[peserta]</td>
											<td>$r[tot]</td>
											";
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
				<div class='panel-heading'>Tambah Persahabatan</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Peserta 1 :</label>
							<select name='peserta1' class="form-control" required>
							<option value=''>-Pilih-Peserta-</option>
							<?
							$tampiluser1=mysql_query("SELECT * FROM peserta order by peserta asc");
							while($user1=mysql_fetch_array($tampiluser1)){
								echo "<option value=$user1[id_peserta]>$user1[peserta]</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Peserta 2 :</label>
							<select name='peserta2' class="form-control" required>
							<option value=''>-Pilih-Peserta-</option>
							<?
							$tampiluser2=mysql_query("SELECT * FROM peserta order by peserta asc");
							while($user2=mysql_fetch_array($tampiluser2)){
								echo "<option value=$user2[id_peserta]>$user2[peserta]</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Peserta 3 :</label>
							<select name='peserta3' class="form-control" required>
							<option value=''>-Pilih-Peserta-</option>
							<?
							$tampiluser3=mysql_query("SELECT * FROM peserta order by peserta asc");
							while($user3=mysql_fetch_array($tampiluser3)){
								echo "<option value=$user3[id_peserta]>$user3[peserta]</option>"; 
							}
							?>
							</select>
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
				<div class='panel-heading'>Edit Persahabatan</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' onsubmit='return validateForm()'>
					<input type=hidden name=id value='<?echo "$r[$idmod]"; ?>'>
						<div class="form-group">
							<label>User :</label>
							<select name='id_user' class="form-control" required>
							<option>-Pilih-User-</option>
							<?
							$tampiluser=mysql_query("SELECT * FROM users");
							while($user=mysql_fetch_array($tampiluser)){
								if($r['id_user']==$user['username']){
									echo "<option value=$user[username] selected>$user[namalengkap]</option>"; 
								}
								else{
									echo "<option value=$user[username]>$user[namalengkap]</option>"; 
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Kategori Nilai :</label>
							<select name='id_kategorinilai' class="form-control" required>
							<option>-Pilih-Kategori-Nilai-</option>
							<?
							$tampilkategorinilai=mysql_query("SELECT * FROM kategorinilai");
							while($kategorinilai=mysql_fetch_array($tampilkategorinilai)){
								if($r['id_kategorinilai']==$kategorinilai['id_kategorinilai']){
									echo "<option value=$kategorinilai[id_kategorinilai] selected>$kategorinilai[kategorinilai]</option>"; 
								}
								else{
									echo "<option value=$kategorinilai[id_kategorinilai]>$kategorinilai[kategorinilai]</option>"; 
								}
							}
							?>
							</select>
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