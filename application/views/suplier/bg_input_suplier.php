<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Single Window</title>
	<link href="<?php echo base_url(); ?>asset/css/style-single.css" rel="stylesheet">
</head>
<body>
	<div id="container">
	<h1><?php echo $jdl; ?> Data - Master Suplier</h1>
		<div id="body">
		<?php echo form_open('suplier/simpan_input'); ?>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="180">Kode Suplier</td><td>:</td><td><input type="text" name="kode_suplier" value="<?php echo $kode_suplier; ?>" class="input-read-only" size="60" readonly="true"></td></tr>
				<tr><td>Nama Suplier</td><td>:</td><td><input type="text" name="nama_suplier" value="<?php echo $nama_suplier; ?>" class="input-read-only" size="60"></td></tr>
				<tr valign="top"><td>Alamat</td><td>:</td><td><textarea name="alamat" class="input-read-only" cols="65" rows="4"><?php echo $alamat; ?></textarea></td></tr>
				<tr><td>Kota</td><td>:</td><td><input type="text" name="kota" value="<?php echo $kota; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Provinsi</td><td>:</td><td><input type="text" name="provinsi" value="<?php echo $provinsi; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Kontak</td><td>:</td><td><input type="text" name="kontak" value="<?php echo $kontak; ?>" class="input-read-only" size="60"></td></tr>
				
				
				<tr valign="top"><td></td><td colspan="2"><input type="submit" class="btn-kirim-login" value="Simpan Data"><input type="reset" class="btn-kirim-login" value="Reset Data"></td></tr>
			</table>
			<input type="hidden" name="stts" value="<?php echo $stts; ?>">
		<?php echo form_close(); ?>
		</div>
	</div>
</body>
</html>