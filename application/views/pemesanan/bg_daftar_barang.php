<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Single Window</title>
	<link href="<?php echo base_url(); ?>asset/css/style-single.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>asset/css/chosen.css" rel="stylesheet" type="text/css">
</head>
<script>
function bolehUbah()
{
	document.getElementById("hargabarang").readOnly=false;
}
</script>
<body>
	<div id="container">
	<h1>Data - Master Barang</h1>
		<div id="body">
		<?php $atr = array('name' => 'frm', 'id' => 'frm'); echo form_open('pemesanan/tambah_barang_pesanan',$atr); ?>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="130">Nama Barang</td><td>:</td><td>
				<select data-placeholder="Cari nama barang..." class="chzn-select" style="width:400px;" tabindex="2" name="kode_barang" id="kode_barang">
          		<option value=""></option> 
					<?php
						foreach($dt_barang->result_array() as $db)
						{
					?>
						<option value="<?php echo $db['kode_barang']; ?>"><?php echo $db['nama_barang']; ?></option>
					<?php
						}
					?>
				</select>
				</td></tr>
				<tr><td colspan="3"><div id="data_barang"></div></td></tr>
			</table>
			<input type="submit" class="btn-kirim-login" value="Tambahkan" disabled="disabled" name="add" id="add">
			<div class="cleaner_h20"></div>
			
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
			<script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js" type="text/javascript"></script>
			<script type="text/javascript"> $(".chzn-select").chosen().change(function(){ 
						var kode_barang = $("#kode_barang").val(); 
						$.ajax({ 
						url: "<?php echo base_url(); ?>pemesanan/ambil_data_barang", 
						data: "kode_barang="+kode_barang, 
						cache: false, 
						success: function(msg){ 
						$("#data_barang").html(msg);
						document.frm.add.disabled=false;
					} 
				})
				});
			</script>
		<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>