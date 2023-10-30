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
            <h3 class="page-header">Manajemen Akses CRUD</h3>
        </div>
	</div>
	
		<? include "list/alert.php";
	
	switch($_GET[act]){
	default: 
	?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($cekcrud['isi']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan Akses CRUD</span></a></p>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Akses CRUD</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Grup Akses</th>
									<th>Modul</th>
									<th>Lihat</th>
									<th>Isi</th>
									<th>Ubah</th>
									<th>Hapus</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("SELECT aksescrud.*,modul.modul, grupakses.grupakses FROM aksescrud,modul,grupakses where aksescrud.id_modul=modul.id_modul and aksescrud.id_grupakses=grupakses.id_grupakses ORDER BY grupakses.id_grupakses");
								while($r=mysql_fetch_array($tampil)){
									$idmod="id_".$mod;
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[grupakses]</td>
											<td>$r[modul]</td>
											<td>$r[lihat]</td>
											<td>$r[isi]</td>
											<td>$r[ubah]</td>
											<td>$r[hapus]</td>
											<td>";
											if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href='?module=$mod&act=edit$mod&id=$r[$idmod]' title='Edit'><i class='fa fa-wrench'></i></a> ";
											}
											if($cekcrud['hapus']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$r[$idmod]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
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
				<div class='panel-heading'>Tambah Akses CRUD</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Grup Akses :</label>
							<select name='id_grupakses' class="form-control" required>
							<option>-Pilih-Grup-Akses-</option>
							<?
							$tampil=mysql_query("SELECT * FROM grupakses");
							while($r=mysql_fetch_array($tampil)){
								$ket="";
								$relasi=mysql_query("select modul.modul from modul,aksescrud, grupakses where aksescrud.id_grupakses=grupakses.id_grupakses and aksescrud.id_modul=modul.id_modul and aksescrud.id_grupakses='$r[id_grupakses]'");
								while($relasi2=mysql_fetch_array($relasi)){
									$ket="$ket, $relasi2[modul] ";
								}
								echo "<option value=$r[id_grupakses]>$r[grupakses] - $ket</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Modul :</label>
							<select name='id_modul' class="form-control" required>
							<option>-Pilih-Modul-</option>
							<?
							$tampil2=mysql_query("SELECT * FROM modul");
							while($r2=mysql_fetch_array($tampil2)){
								echo "<option value=$r2[id_modul]>$r2[modul]</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Lihat :</label>
                            <input type="checkbox" name='lihat' value='y'> - <label>Isi :</label> <input type="checkbox" name='isi' value='y'> - <label>Ubah :</label> <input type="checkbox" name='ubah' value='y'> - <label>Hapus :</label><input type="checkbox" name='hapus' value='y'>
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
				<div class='panel-heading'>Edit Akses CRUD</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' onsubmit='return validateForm()'>
					<input type=hidden name=id value='<?echo "$r[$idmod]"; ?>'>
						<div class="form-group">
							<label>Grup Akses :</label>
							<select name='id_grupakses' class="form-control" required>
							<option>-Pilih-Grup-Akses-</option>
							<?
							$tampil=mysql_query("SELECT * FROM grupakses");
							while($g=mysql_fetch_array($tampil)){
								$ket="";
								$relasi=mysql_query("select modul.modul from modul,aksescrud, grupakses where aksescrud.id_grupakses=grupakses.id_grupakses and aksescrud.id_modul=modul.id_modul and aksescrud.id_grupakses='$g[id_grupakses]'");
								while($relasi2=mysql_fetch_array($relasi)){
									$ket="$ket, $relasi2[modul] ";
								}
								if($r[id_grupakses]==$g[id_grupakses]){
									echo "<option value=$g[id_grupakses] selected>$g[grupakses] - $ket</option>"; 
								}
								else{
									echo "<option value=$g[id_grupakses]>$g[grupakses] - $ket</option>"; 
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Modul :</label>
							<select name='id_modul' class="form-control" required>
							<option>-Pilih-Modul-</option>
							<?
							$tampil2=mysql_query("SELECT * FROM modul");
							while($r2=mysql_fetch_array($tampil2)){
								if($r[id_modul]==$r2[id_modul]){
									echo "<option value=$r2[id_modul] selected>$r2[modul]</option>"; 
								}
								else{
									echo "<option value=$r2[id_modul]>$r2[modul]</option>"; 
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label class="checkbox-inline">
                                                
							<?
								if($r[lihat]=='y'){
									echo"<label class='checkbox-inline'><input type='checkbox' name='lihat' value='y' checked>Lihat</label>";
								}
								else{
									echo"<label class='checkbox-inline'><input type='checkbox' name='lihat' value='y'>Lihat</label>";
								}
								if($r[isi]=='y'){
									echo"<label class='checkbox-inline'><input type='checkbox' name='isi' value='y' checked>Isi</label>";
								}
								else{
									echo"<label class='checkbox-inline'><input type='checkbox' name='isi' value='y'>Isi</label>";
								}
								if($r[ubah]=='y'){
									echo"<label class='checkbox-inline'><input type='checkbox' name='ubah' value='y' checked>Ubah</label>";
								}
								else{
									echo"<label class='checkbox-inline'><input type='checkbox' name='ubah' value='y'>Ubah</label>";
								}
								if($r[hapus]=='y'){
									echo"<label class='checkbox-inline'><input type='checkbox' name='hapus' value='y' checked>Hapus</label>";
								}
								else{
									echo"<label class='checkbox-inline'><input type='checkbox' name='hapus' value='y'>Hapus</label>";
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