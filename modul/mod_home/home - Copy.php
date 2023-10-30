<script>
function confirmdelete(delUrl) {
   if (confirm("Anda yakin ingin menghapus?")) {
      document.location = delUrl;
   }
}
</script>

<script type="text/javascript">
	
	// PENCARIAN MELALUI TEXT BOX
	$(document).ready(function(){
		$(".hasil").hide();
		setTimeout(function(){
			$("#loader").hide("slow");
		},1500);
		setTimeout(function(){
			$(".hasil").fadeIn();
		},2000);
	});
	$(document).ready(function(){
		$("input").blur(function(){
			$('#pencarian').fadeOut();
		});
	});
	
	function lookup(inputString) {
		if(inputString.length == 0) {
			$('#pencarian').fadeOut(); // sembunyikan div pencarian
		} else {
			$.post("cari.php", {queryString: ""+inputString+""}, function(data) { // proses ajax request
				$('#pencarian2').hide(); // sembunyikan div pencarian
				$('#pencarian').fadeIn(); // tampilkan div pencarian
				$('#pencarian').html(data); // isi div pencarian
			});
		}
	};

	// PENCARIAN COMBO BOX
	$(document).ready(function() {
		$("#wilayah").searchit( { textFieldClass: 'form-control' } );
		$("#jemaat").searchit( { textFieldClass: 'form-control' } );
	});

// DYNAMIC COMBO BOX
var htmlobjek;
$(document).ready(function(){
  //apabila terjadi event onchange terhadap object <select id=propinsi>
  $("#kabkota").change(function(){
    var kabkota = $("#kabkota").val();
    $.ajax({
        url: "list/ambilkota.php",
        data: "kabkota="+kabkota,
        cache: false,
        success: function(msg){
            //jika data sukses diambil dari server kita tampilkan
            //di <select id=kota>
            $("#kecamatan").html(msg);
        }
    });
  });
  $("#kecamatan").change(function(){
    var kecamatan = $("#kecamatan").val();
    $.ajax({
        url: "list/ambilkecamatan.php",
        data: "kecamatan="+kecamatan,
        cache: false,
        success: function(msg){
            $("#kelurahan").html(msg);
        }
    });
  });
});

// VALIDASI
$(document).ready(function() {
    $("#isian").validate({
			rules: {
				jumlahkolom: {
					digits: true,
					required: 2
				},
				email: {
					required: true,
					email: true
				},
			},
			messages: {
				jumlahkolom: {
					required: "Please enter ajumlahkolom",
					digits: "harus angka"
				},
				email: {
					email: "Please enter a valid email address",
				}
			},
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
if($cek==1 OR $_SESSION[leveluser]=='admin' OR $_SESSION[leveluser]=='userjemaat'){
	$cekcrud=user_akses_crud($_GET[module],$_SESSION[sessid]);
	$aksi="modul/mod_$mod/aksi_$mod.php";
	?>
	
<div id="page-wrapper">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="page-header">Halaman Percobaan ^_^</h3>
        </div>
	</div><?
	
	switch($_GET[act]){
	default: ?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<form id='isian'>
			
			<div class="form-group input-group">
                <input type="text" class="form-control" onkeyup="lookup(this.value);">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button"><i class="fa fa-search"></i></button>
                </span>
            </div>
			<div id=pencarian></div>
			
			<div class="form-group">
				<select class="form-control" id="wilayah" name='wilayah'>
					<?
					$wil=mysql_query("select * from wilayah ");
					while($w=mysql_fetch_array($wil)){
						echo"<option value='$w[id_wilayah]'>$w[wilayah]</option>";
					}
					?>
                </select>
            </div>
			<div class="form-group">
				<select class="form-control" id="jemaat" name='jemaat'>
					<?
					$wil=mysql_query("select * from jemaat ");
					while($w=mysql_fetch_array($wil)){
						echo"<option value='$w[id_jemaat]'>$w[jemaat]</option>";
					}
					?>
                </select>
            </div>
			
			<div class="form-group">
				<label for=field4>Kabupaten/Kota</label>
				<select class="form-control" name='id_kabkota' id='kabkota' data-validation="required number">
					<option>--Pilih Kabupaten/Kota--</option>
					<?
					$propinsi = mysql_query("SELECT * FROM kabkota ORDER BY kabkota");
					while($p=mysql_fetch_array($propinsi)){
						echo"<option value='$p[id_kabkota]' >$p[kabkota]</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for=field4>Kecamatan</label>
				<select class="form-control" name='id_kecamatan' id= 'kecamatan'>
					<option>--Pilih Kecamatan--</option>
					<?
					$kota = mysql_query("SELECT * FROM kecamatan ORDER BY kecamatan");
					while($p=mysql_fetch_array($kota)){
						echo "<option value='$p[id_kecamatan]'>$p[kecamatan]</option>";
					}
					?>
				</select>
			</div>
			<div class="form-group">
				<label for=field4>Kelurahan</label>
				<select class="form-control" name='id_kelurahan' id='kelurahan' data-validation="required number">
					<option>--Pilih Kelurahan--</option>
					<?
					$kecamatan = mysql_query("SELECT * FROM kelurahan ORDER BY kelurahan");
					while($p=mysql_fetch_array($kecamatan)){
						echo "<option value='$p[id_kelurahan]'>$p[kelurahan]</option>";
					}
					?>
				</select>
			</div>
			
				
		
						<div class="form-group">
							<label for=field4>Jumlah KK</label>
							<input class="form-control" type=text name='jumlahkk' id='jumlahkk' data-validation="number" >
						</div>    

						<div class="form-group" id="group-jumlahkolom">
							<label class="control-label">Jumlah Kolom</label>
							<input class="form-control" type=text name='jumlahkolom' id='jumlahkolom'>
						</div>
						
						<div class="form-group">
							<label class="control-label">Isian</label>
							<input class="form-control" type=text name='email' id='email' >
						</div>   
						
						<button type="submit" class="btn btn-default">Simpan</button>
						<button type="reset" class="btn btn-default">Batal</button>

					
	</form>
 
		</div>
	</div>
	<? 
	break;
	
	case "tambah$mod": 
	if($cekcrud['isi']=='y' OR $_SESSION[leveluser]=='admin'){ ?>
	
	<div class='row'>
		<div class='col-lg-12'>
			
			<? if($_GET[err]=='ada'){ ?>
				<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Wilayah Sudah Pernah Diisi.
                </div>
			<? } if($_GET[affect]=='ya'){ ?>
				<div class="alert alert-success alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Wilayah Berhasil Diinput.
                </div>
			<? } if($_GET[affect]=='tdk'){ ?>
				<div class="alert alert-danger alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Wilayah Gagal Diinput.
                </div>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Tambah Wilayah</div>
				<div class="panel-body">
					<form role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=input";?>' onsubmit='return validateForm()'>
						<div class="form-group">
							<label>Wilayah :</label>
							<input class="form-control" type=text name='<?=$mod?>' id='<?=$mod;?>' >
						</div>
						<button type="submit" class="btn btn-default">Simpan</button>
						<button type="reset" class="btn btn-default">Batal</button>
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
			
			<? if($_GET[err]=='ada'){ ?>
				<div class="alert alert-warning alert-dismissable">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    Wilayah Sudah Pernah Diisi.
                </div>
			<? } ?>
			
			<div class='panel panel-default'>
				<div class='panel-heading'>Edit Wilayah</div>
				<div class="panel-body">
					<form role="form" name='isian' id='isian' method=POST action='<?echo"$aksi?module=$mod&act=update";?>' onsubmit='return validateForm()'>
					<input type=hidden name=id value='<?echo "$r[$idmod]"; ?>'>
						<div class="form-group">
							<label>Wilayah :</label>
							<input class="form-control" type=text name='<?=$mod;?>' id='<?=$mod;?>' value='<?=$r[$mod] ?>'>
						</div>
						<button type="submit" class="btn btn-default">Simpan</button>
						<button type="reset" class="btn btn-default">Batal</button>
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