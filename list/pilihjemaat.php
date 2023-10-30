<?
if(isset($_POST[id_jemaat])){
	session_start();
	$_SESSION[id_jemaat]= $_POST[id_jemaat];
	?>
	<meta http-equiv="refresh" content="0; url=media.php?module=<?=$_POST[module];?>" />
	<?
}else{
?>
<script type="text/javascript">
	$(document).ready(function() {
		$("#jemaat").searchit( { textFieldClass: 'form-control' } );
	});
</script>
<div class='row'>
	<div class='col-lg-12'>
		<form role="form" name='isian' id='isian' method=POST action='' >
			<input type=hidden name=module value='<?=$_GET[module]?>'>
			<div class="form-group">
				<label class="control-label">Piih Jemaat : </label>
				<div class="input-group">
					<span class="input-group-addon"><i class="fa fa-search"></i></span>
					<select class="form-control" id="jemaat" name='id_jemaat'>
						<?
						$sql=mysql_query("select * from jemaat t1, wilayah t2 WHERE t1.id_wilayah=t2.id_wilayah");
						while($r=mysql_fetch_array($sql)){
							echo"<option value='$r[id_jemaat]'>$r[jemaat] $r[wilayah]</option>";
							}
						?>
			        </select>
			        <span class="input-group-btn">
	                    <button class="btn btn-primary" type="submit"><i class="fa fa-arrow-right"></i></button>
	                </span>
		    	</div>
		    </div>
		</form>
	</div>
</div>
<? } ?>