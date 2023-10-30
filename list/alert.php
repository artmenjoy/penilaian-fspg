<div class="row">
    <div class="col-lg-12">
    <? if($_GET[err]=='sql'){ ?>
		<div class="alert alert-danger alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Data tidak bisa dihapus karena berkaitan dengan data yang lainnya. Hapus dahulu data yang berkaitan tersebut.
        </div>
	<? } if($_GET[err]=='ada'){ ?>
		<div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Data Sudah Pernah Diinput.
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
		<div class="alert alert-warning alert-dismissable">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            Data Gagal Dihapus.
        </div>
	<? } ?>
    </div>
</div>