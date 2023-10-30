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
            <h3 class="page-header">Manajemen Modul</h3>
        </div>
	</div>
	
		<? if($_GET[err]=='sql'){ ?>
				<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Data tidak bisa dihapus karena berkaitan dengan data yang lainnya. Hapus dahulu data yang berkaitan tersebut.
                </div>
			<? } if($_GET[affect]=='ya'){ ?>
				<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Data Berhasil Disimpan.
                </div>
			<? } if($_GET[affect]=='ya2'){ ?>
				<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Data Berhasil Dihapus.
                </div>
			<? } if($_GET[affect]=='tdk'){ ?>
				<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Data Gagal Disimpan.
                </div>
			<? } if($_GET[affect]=='tdk2'){ ?>
				<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                   Data Gagal Dihapus.
               </div>
			<? } if($_GET[err]=='ada'){ ?>
				<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Data Sudah Pernah Diisi.
                </div>
		<? } 
	
	switch($_GET[act]){
	default: ?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($cekcrud['isi']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan Modul</span></a></p>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Modul</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama Modul</th>
									<th>Parent</th>
									<th>Link</th>
									<th>Icon</th>
									<th>Urutan</th>
									<th>Aktif</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("SELECT modul.*,parent.parent FROM modul,parent where parent.id_parent=modul.id_parent ORDER BY modul.modul ASC");
								while($r=mysql_fetch_array($tampil)){
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[modul]</td>
											<td>$r[parent]</td>
											<td>$r[link]</td>
											<td>$r[icon]</td>
											<td>$r[urutan]</td>
											<td>$r[aktif]</td>
											<td>";
											if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href='?module=$mod&act=edit$mod&id=$r[id_modul]' title='Edit'><i class='fa fa-wrench'></i></a> ";
											}
											if($cekcrud['hapus']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$r[id_modul]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
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
				<div class='panel-heading'>Tambah Modul</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Nama Modul :</label>
							<input class="form-control" type=text name='modul' placeholder='Nama Modul' required>
						</div>
						<div class="form-group">
							<label>Link :</label>
							<input class="form-control" type=text name='link' placeholder='Link' required>
						</div>
						<div class="form-group">
							<label>Icon :</label>
							<input class="form-control" type=text name='icon' id='icon' placeholder="gambar icon" required >
						</div>
						<div class="form-group">
							<label>Parent :</label>
							<select name='id_parent' class="form-control" required>
							<option>-Pilih-Parent-</option>
							<?
							$tampil=mysql_query("SELECT * FROM parent ORDER BY urutan");
							while($r=mysql_fetch_array($tampil)){
								echo "<option value=$r[id_parent]>$r[parent]</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Urutan :</label>
							<input class="form-control" type=number min='1' max='99' name='urutan' id='urutan' placeholder="urutan ke" required>
						</div>
						<div class="form-group">
							<label class="control-label">Aktif :</label>
							<div class="form-control">
								<label class="radio-inline">
									<input type="radio" name="aktif" value="Y" checked>Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="aktif"  value="T">Tidak
								</label>
							</div>
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
	$r=mysql_fetch_array(mysql_query("SELECT * FROM modul where id_modul='$_GET[id]'"));
	?>
	<div class='row'>
		<div class='col-lg-12'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Edit Modul</div>
				<div class="panel-body">
					<form data-toggle="validator" role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' >
					<input type=hidden name=id value='<?echo "$r[id_modul]"; ?>'>
						<div class="form-group">
							<label>Nama Modul :</label>
							<input class="form-control" type=text name='modul' value='<?=$r[modul];?>' required>
						</div>
						<div class="form-group">
							<label>Link :</label>
							<input class="form-control" type=text name='link' value='<?=$r[link];?>'>
						</div>
						<div class="form-group">
							<label>Icon :</label>
							<input class="form-control" type=text name='icon' id='icon' placeholder="gambar icon" value='<?=$r[icon];?>' required >
						</div>
						<div class="form-group">
							<label>Parent :</label>
							<select name='id_parent' class="form-control" value='<?=$r[id_parent];?>' required>
							<option>-Pilih-Parent-</option>
							<?
							$tampil=mysql_query("SELECT * FROM parent ORDER BY urutan");
							while($rr=mysql_fetch_array($tampil)){
								if($rr['id_parent']==$r['id_parent']){
									echo "<option value=$rr[id_parent] selected>$rr[parent]</option>"; 
								}
								else{
									echo "<option value=$rr[id_parent]>$rr[parent]</option>"; 
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Urutan :</label>
							<input class="form-control" type=number min='1' max='99' name='urutan' id='urutan' placeholder="urutan ke" value='<?=$r[urutan];?>' required>
						</div>
						<div class="form-group">
							<label class="control-label">Aktif :</label>
							<div class="form-control">
							<? if($r[aktif]=='Y'){ ?>
								<label class="radio-inline">
									<input type="radio" name="aktif" value="Y" checked>Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="aktif"  value="T">Tidak
								</label>
							<? }else{ ?>
								<label class="radio-inline">
									<input type="radio" name="aktif" value="Y">Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="aktif"  value="T" checked>Tidak
								</label>
							<? } ?>
							</div>
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