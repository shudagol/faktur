<div id="container">
	<h1><?php echo $nama_perusahaan; ?></h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<?php
			echo $bio;
			echo $menu;
		?>
		<div class="cleaner_h10"></div>
		<table align="center">
			<tr align="center">
				<td>
					<?php
						echo $paginator;
					?>
				</td>
			</tr>
		</table>
		<div class="cleaner_h10"></div>
		<table border="1" cellpadding="3" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record" bordercolor="#CCCCCC">
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="8" height="25">MANAJEMEN PENGGUNA</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Username</td>
				<td>Nama Lengkap</td>
				<td>Status</td>
				<td colspan="3"><a href="<?php echo base_url(); ?>user/tambah" class="cbuser"><div class="btn-add">Tambah Data</div></a></td>
			</tr>
			<?php
				$no = 1;
				if($dt_user->num_rows()>0)
				{
					foreach($dt_user->result_array() as $db)
					{
				?>
				<tr>
					<td><?php echo $no; ?></td>
					<td><?php echo $db['username']; ?></td>
					<td><?php echo $db['nama_pengguna']; ?></td>
					<td><?php echo $db['stts']; ?></td>
					<td width="90"><a href="<?php echo base_url(); ?>user/edit/<?php echo $db['username']; ?>" class="cbuser"><div class="btn-edit">
					Edit Data</div></a></td>
					<td width="100">
					<a href="<?php echo base_url(); ?>user/hapus/<?php echo $db['username']; ?>" onclick="return confirm('Anda yakin?');"><div class=
					"btn-delete">Hapus Data</div></a></td>
				</tr>
				<?php
					$no++;
					}
				}
				else
				{
					?>
					
				<tr style="text-align:center;">
					<td colspan="6">Belum ada data</td>
				</tr>
					<?php
				}
			?>
		</table>
		<div class="cleaner_h10"></div>
		<table align="center">
			<tr align="center">
				<td>
					<?php
						echo $paginator;
					?>
				</td>
			</tr>
		</table>
	</div>
