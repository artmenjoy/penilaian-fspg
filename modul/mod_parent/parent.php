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
            <h3 class="page-header">Manajemen Parent</h3>
        </div>
	</div>
	
		<? include "list/alert.php";
	
	switch($_GET[act]){
	default: 
	?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($cekcrud['lihat']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan Parent</span></a></p>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Parent</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Parent</th>
									<th>Icon</th>
									<th>Urutan</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("SELECT * FROM $mod ORDER BY id_$mod DESC");
								while($r=mysql_fetch_array($tampil)){
									$idmod="id_".$mod;
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[$mod]</td>
											<td>$r[icon]</td>
											<td>$r[urutan]</td>
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
				<div class='panel-heading'>Tambah Parent</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Parent :</label>
							<input class="form-control" type=text name='<?=$mod?>' id='<?=$mod;?>' placeholder="<?=$mod;?>" required >
						</div>
						<div class="form-group">
							<label>Urutan :</label>
							<input class="form-control" type=number min='1' max='99' name='urutan' id='urutan' placeholder="urutan ke" required>
						</div>
						<div class="form-group">
							<label>Icon :</label>
							<input class="form-control" type=text name='icon' id='icon' placeholder="gambar icon" required >
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
				<div class='panel-heading'>Edit Parent</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' onsubmit='return validateForm()'>
					<input type=hidden name=id value='<?echo "$r[$idmod]"; ?>'>
						<div class="form-group">
							<label>Parent :</label>
							<input class="form-control" type=text name='<?=$mod;?>' id='<?=$mod;?>' value='<?=$r[$mod] ?>' required>
						</div>

						<div class="form-group">
							<label>Urutan :</label>
							<input class="form-control" type=text name='urutan' id='urutan' placeholder="urutan ke" value='<?=$r[urutan] ?>' required>
						</div>
						<div class="form-group">
							<label>Icon :</label>
							<input class="form-control" type=text name='icon' id='icon' placeholder="gambar icon" value='<?=$r[icon] ?>' required >
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