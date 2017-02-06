<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Single Window</title>
	<link href="<?php echo base_url(); ?>asset/css/style-single.css" rel="stylesheet">
</head>
<body>
	<div id="container">
	<h1><?php echo $jdl; ?> - Master Barang</h1>
		<div id="body">
		<?php echo form_open('barang/simpan_input'); ?>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="100">Kode Barang</td><td>:</td><td><input type="text" name="kode_barang" value="<?php echo $kode_barang; ?>" class="input-read-only" size="60" readonly="true"></td></tr>
				<tr><td>Nama Barang</td><td>:</td><td><input type="text" name="nama_barang" value="<?php echo $nama_barang; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Stok Barang</td><td>:</td><td><input type="text" name="stok" value="<?php echo $stok; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Harga Barang</td><td>:</td><td><input type="text" name="harga_barang" value="<?php echo $harga_barang; ?>" class="input-read-only" size="60"></td></tr>

				<tr><td width="100">Nama Suplier</td><td>:</td><td>
				<select data-placeholder="Cari nama suplier..." class="input-read-only" style="width:400px;" tabindex="2" name="kode_suplier" id="kode_suplier" >
          		<option value=""></option> 
					<?php
						foreach($dt_suplier->result_array() as $dp)
						{
						$pilih='';
						if($dp['kode_suplier']==$this->session->userdata("kd_suplier"))
						{
						$pilih='selected="selected"';
					?>
						<option value="<?php echo $dp['kode_suplier']; ?>" <?php echo $pilih; ?>><?php echo $dp['nama_suplier']; ?></option>
					<?php
					}
					else
					{
					?>
						<option value="<?php echo $dp['kode_suplier']; ?>"><?php echo $dp['nama_suplier']; ?></option>
					<?php
					}
						}
					?>
				</select>
				</td></tr>


				<tr><td>Harga Beli</td><td>:</td><td><input type="text" name="harga_beli" value="<?php echo $harga_beli; ?>" class="input-read-only" size="60"></td></tr>


				<tr valign="top"><td>Keterangan</td><td>:</td><td><textarea name="keterangan" class="input-read-only" cols="65" rows="5"><?php echo $keterangan; ?></textarea></td></tr>
				<tr valign="top"><td></td><td colspan="2"><input type="submit" class="btn-kirim-login" value="Simpan Data"><input type="reset" class="btn-kirim-login" value="Reset Data"></td></tr>
			</table>
			<input type="hidden" name="stts" value="<?php echo $stts; ?>">
		<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>