<script>
function confirmdelete(delUrl) {
	if(confirm("Anda yakin ingin menghapus?")) {
		document.location = delUrl;
	}
}
// VALIDASI
$(document).ready(function() {
    $("#isian").validate({
			rules: {
				namalengkap: {
					required: true,
					minlength: 4,
				},
				username: {
					required: true,
					minlength: 8,
				},
				password: {
					required: true,
					minlength: 8,
				},
				cpassword: {
					required: true,
					minlength: 8,
					equalTo: '#password',
				},
				passwordbaru: {
					minlength: 8,
				},
				cpasswordbaru: {
					equalTo: '#passwordbaru'
				},
				email: {
					email: true,
				},
				notelp: {
					digits: true,
				},
			}
		});
});
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
            <h3 class="page-header">Manajemen User</h3>
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
			<p><a href='?module=<?=$mod;?>&act=tambah<?=$mod;?>' class='btn btn-primary'><span>Tambahkan User</span></a></p>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>User</div>
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover" id="dataTables">
							<thead>
								<tr>
									<th>No</th>
									<th>Nama</th>
									<th>Grup Akses</th>
									<th>Username</th>
									<th>email</th>
									<th>No.Telp</th>
									<th>Blokir</th>
									<th>Aksi</th>
								</tr>
							</thead>
							<tbody>
								<?
								$no=1;
								$tampil = mysql_query("SELECT users.*, grupakses.grupakses FROM users,grupakses WHERE users.id_grupakses=grupakses.id_grupakses and users.id_userslevel=2 ORDER BY users.username ASC");
								while($r=mysql_fetch_array($tampil)){
									echo"<tr class='gradeX'>
											<td width=50><center>$no</center></td>
											<td>$r[namalengkap]</td>
											<td>$r[grupakses]</td>
											<td>$r[username]</td>
											<td>$r[email]</td>
											<td>$r[notelp]</td>
											<td>$r[blokir]</td>
											<td>";
											if($cekcrud['ubah']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href='?module=$mod&act=edit$mod&id=$r[id_session]' title='Edit'><i class='fa fa-wrench'></i></a> ";
											}
											if($cekcrud['hapus']=='y' OR $_SESSION[leveluser]=='admin'){
												echo"<a href=javascript:confirmdelete('$aksi?module=$mod&act=hapus&id=$r[id_session]') title='Hapus'><i class='fa fa-times-circle text-danger'></i></a> ";
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
				<div class='panel-heading'>Tambah User</div>
				<div class="panel-body">
					<form role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>'>
						<div class="form-group">
							<label>Nama Lengkap :</label>
							<input class="form-control" type=text name='namalengkap' placeholder='Nama Lengkap'>
						</div>
						<div class="form-group">
							<label>Username :</label>
							<input class="form-control" type=text name='username' placeholder='Username'>
						</div>
						<div class="form-group">
							<label>Grup Akses :</label>
							<select name='id_grupakses' class="form-control" required>
							<option>-Pilih-Grup-Akses-</option>
							<?
							$tampil=mysql_query("SELECT * FROM grupakses");
							while($r=mysql_fetch_array($tampil)){
								echo "<option value=$r[id_grupakses]>$r[grupakses]</option>"; 
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Password :</label>
							<input class="form-control" type=password name='password' id='password'  placeholder='Passwrod'>
						</div>
						<div class="form-group">
							<input class="form-control" type=password name='cpassword' placeholder='Cek Password'>
						</div>
						<div class="form-group">
							<label>email :</label>
							<input class="form-control" type=text name='email' placeholder='email'>
						</div>
						<div class="form-group">
							<label>No.Telp :</label>
							<input class="form-control" type=text name='notelp'  placeholder='No.Telp'>
						</div>
						<div class="form-group">
							<label class="control-label">Blokir :</label>
							<div class="form-control">
								<label class="radio-inline">
									<input type="radio" name="blokir" value="Y" checked>Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="blokir"  value="T">Tidak
								</label>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn btn-primary">Batal</button>	
					
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
	$r=mysql_fetch_array(mysql_query("SELECT * FROM users WHERE id_session='$_GET[id]' AND username!='admin' "));
	?>
	<div class='row'>
		<div class='col-lg-12'>
			<div class='panel panel-default'>
				<div class='panel-heading'>Edit User</div>
				<div class="panel-body">
					<form role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' >
					<input type=hidden name=id value='<?echo "$r[id_session]"; ?>'>
						<div class="form-group">
							<label>Nama Lengkap :</label>
							<input class="form-control" type=text name='namalengkap' value='<?=$r[namalengkap];?>'>
						</div>
						<div class="form-group">
							<label>Username :</label>
							<input class="form-control" type=text name='username' value='<?=$r[username];?>' disabled>
						</div>
						<div class="form-group">
							<label>Grup Akses :</label>
							<select name='id_grupakses' class="form-control" required>
							<option>-Pilih-Grup-Akses-</option>
							<?
							$tampil=mysql_query("SELECT * FROM grupakses");
							while($r2=mysql_fetch_array($tampil)){
								if($r[id_grupakses]==$r2[id_grupakses]){
									echo "<option value=$r2[id_grupakses] selected>$r2[grupakses]</option>"; 
								}
								else{
									echo "<option value=$r2[id_grupakses]>$r2[grupakses]</option>"; 
								}
							}
							?>
							</select>
						</div>
						<div class="form-group">
							<label>Ganti Password :</label>
							<input class="form-control" type=password name='passwordbaru' id='passwordbaru' placeholder='Kosongkan jika tidak diganti'>
						</div>
						<div class="form-group">
							<input class="form-control" type=password name='cpasswordbaru' placeholder='Cek password baru'>
						</div>
						<div class="form-group">
							<label>email :</label>
							<input class="form-control" type=text name='email' placeholder='email' value='<?=$r[email];?>'>
						</div>
						<div class="form-group">
							<label>No.Telp :</label>
							<input class="form-control" type=text name='notelp'  placeholder='' value='<?=$r[notelp];?>'>
						</div>
						<div class="form-group">
							<label class="control-label">Blokir :</label>
							<div class="form-control">
							<? if($r[blokir]=='Y'){ ?>
								<label class="radio-inline">
									<input type="radio" name="blokir" value="Y" checked>Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="blokir"  value="T">Tidak
								</label>
							<? }else{ ?>
								<label class="radio-inline">
									<input type="radio" name="blokir" value="Y">Ya
								</label>
								<label class="radio-inline">
									<input type="radio" name="blokir"  value="T" checked>Tidak
								</label>
							<? } ?>
							</div>
						</div>
						<button type="submit" class="btn btn-primary">Simpan</button>
						<button type="reset" class="btn btn-primary">Batal</button>
					</form>
				</div>
			</div>
			
		</div>
	</div>
	<?
	}
	break;

	?>
</div>

<?
}
}else{
	echo akses_salah();
}
}
?>