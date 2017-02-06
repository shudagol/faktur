<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Single Window</title>
	<link href="<?php echo base_url(); ?>asset/css/style-single.css" rel="stylesheet">
</head>
<body>
	<div id="container">
	<h1><?php echo $jdl; ?> Data - Master Pelanggan</h1>
		<div id="body">
		<?php echo form_open('pelanggan/simpan_input'); ?>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="180">Kode Pelanggan</td><td>:</td><td><input type="text" name="kode_pelanggan" value="<?php echo $kode_pelanggan; ?>" class="input-read-only" size="60" readonly="true"></td></tr>
				<tr><td>Nama Pelanggan</td><td>:</td><td><input type="text" name="nama_pelanggan" value="<?php echo $nama_pelanggan; ?>" class="input-read-only" size="60"></td></tr>
				<tr valign="top"><td>Alamat</td><td>:</td><td><textarea name="alamat" class="input-read-only" cols="65" rows="4"><?php echo $alamat; ?></textarea></td></tr>
				<tr><td>Kota</td><td>:</td><td><input type="text" name="kota" value="<?php echo $kota; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Provinsi</td><td>:</td><td><input type="text" name="provinsi" value="<?php echo $provinsi; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>No. Telepon</td><td>:</td><td><input type="text" name="no_telp" value="<?php echo $no_telp; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Hutang</td><td>:</td><td><input type="text" name="hutang" value="<?php echo $hutang; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Status Pembayaran</td><td>:</td><td>
				<select name="stts_bayar" class="input-read-only">
					<?php
						if($stts_bayar=="Lancar")
						{
							?>
							<option value="Lancar" selected="selected">Lancar</option>
							<option value="Macet">Macet</option>
							<?php
						}
						else if($stts_bayar=="Macet")
						{
							?>
							<option value="Lancar">Lancar</option>
							<option value="Macet" selected="selected">Macet</option>
							<?php
						}
						else
						{
							?>
							<option value="-" selected="selected">- Pilih -</option>
							<option value="Lancar">Lancar</option>
							<option value="Macet">Macet</option>
							<?php
						}
					?>
				</select>
				</td></tr>
				<tr valign="top"><td></td><td colspan="2"><input type="submit" class="btn-kirim-login" value="Simpan Data"><input type="reset" class="btn-kirim-login" value="Reset Data"></td></tr>
			</table>
			<input type="hidden" name="stts" value="<?php echo $stts; ?>">
		<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>