<link href="<?php echo base_url(); ?>asset/css/chosen.css" rel="stylesheet" type="text/css">
<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h10"></div>
	<h6><?php echo $jdl; ?> Data - Faktur</h6>
		<div id="body">
		<?php echo form_open('faktur/tambah_faktur', 'name="frm"'); ?>
		<h3> Data Pelanggan & Faktur</h3>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="110">Kode Faktur</td><td width="20">:</td><td width="300"><input type="text" value="<?php echo $kode_faktur; ?>" class="input-read-only" readonly=
				"true" style="width:280px;" name="kode_faktur" /></td>
				<td width="110">Kode Pesanan</td><td>:</td><td width="300">
				<select data-placeholder="Cari kode pesanan..." class="chzn-select" style="width:280px;" tabindex="2" name="kode_pesanan" id="kode_pesanan">
          		<option value=""></option> 
					<?php
						foreach($dt_pesanan->result_array() as $dp)
						{
					?>
						<option value="<?php echo $dp['kode_pesanan']; ?>"><?php echo $dp['kode_pesanan']; ?></option>
					<?php
						}
					?>
				</select></td></tr>
				
			</table>
			<div id="data_pesanan"></div>
			<script src="<?php echo base_url(); ?>asset/js/chosen.jquery.js" type="text/javascript"></script>
			<script type="text/javascript"> $(".chzn-select").chosen().change(function(){ 
						var kode_pesanan = $("#kode_pesanan").val(); 
						$.ajax({ 
						url: "<?php echo base_url(); ?>faktur/ambil_data_pesanan_ajax", 
						data: "kode_pesanan="+kode_pesanan, 
						cache: false, 
						success: function(msg){ 
						$("#data_pesanan").html(msg); 
					} 
				})
				});
			</script>
		<?php echo form_close(); ?>
		</div>
	</div>