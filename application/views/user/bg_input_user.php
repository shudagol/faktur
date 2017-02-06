<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>Single Window</title>
	<link href="<?php echo base_url(); ?>asset/css/style-single.css" rel="stylesheet">
</head>
<body>
	<div id="container">
	<h1><?php echo $jdl; ?> - Master User</h1>
		<div id="body">
		<?php echo $this->session->flashdata('gagal_user'); ?>
		<?php echo form_open('user/simpan_input'); ?>
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td>Nama</td><td>:</td><td><input type="text" name="nama_pengguna" value="<?php echo $nama_pengguna; ?>" class="input-read-only" size="60"></td></tr>
				<tr><td>Username</td><td>:</td><td><input type="text" name="username" value="<?php echo $username; ?>" class="input-read-only" size="60" <?php if($stts_input=="edit"){ echo 'readonly="true"'; } ?>></td></tr>
				<tr><td>Password</td><td>:</td><td><input type="text" name="password" value="<?php echo $password; ?>" class="input-read-only" size="60"> *</td></tr>
				<tr><td>Status</td><td>:</td><td>
				<select class="input-read-only" name="stts">
				<?php
				if($stts=="admin")
				{
				?>
					<option value="admin" selected="selected">Admin</option>
					<option value="-">- Pilih -</option>
				<?php
				}
				else
				{
				?>
					<option value="-" selected="selected">- Pilih -</option>
					<option value="admin">Admin</option>
				<?php
				}
				?>
				</select>
				</td></tr>
				<tr valign="top"><td></td><td colspan="2"><input type="submit" class="btn-kirim-login" value="Simpan Data"><input type="reset" class="btn-kirim-login" value="Reset Data"></td></tr>
				<tr valign="top"><td></td><td colspan="2"> <?php if($stts_input=="edit"){ echo '* Kosongkan jika tidak diganti'; } ?></td></tr>
			</table>
			<input type="hidden" name="stts_input" value="<?php echo $stts_input; ?>">
		<?php echo form_close(); ?>
		<div class="cleaner_h10"></div>
		</div>
	</div>
</body>
</html>