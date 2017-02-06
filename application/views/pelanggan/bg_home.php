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
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="7" height="25">MASTER PELANGGAN</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>Kode Pelanggan</td>
				<td>Nama Pelanggan</td>
				<td>No. Telepon</td>
				<td>Sisa Hutang</td>
				<td>Status</td>
				<td colspan="2"><a href="<?php echo base_url(); ?>pelanggan/tambah" class="cbpelanggan"><div class="btn-add">Tambah Data</div></a></td>
			</tr>
			<?php
				if($dt_pelanggan->num_rows()>0)
				{
					foreach($dt_pelanggan->result_array() as $db)
					{
				?>
				<tr>
					<td><?php echo $db['kode_pelanggan']; ?></td>
					<td><?php echo $db['nama_pelanggan']; ?></td>
					<td><?php echo $db['no_telp']; ?></td>
					<td>Rp. <?php echo number_format($db['hutang'],2,',','.'); ?></td>
					<td><?php echo $db['stts']; ?></td>
					<td width="90"><a href="<?php echo base_url(); ?>pelanggan/edit/<?php echo $db['kode_pelanggan']; ?>" class="cbpelanggan"><div class="btn-edit">Edit Data</div></a></td>
					<td width="100"><a href="<?php echo base_url(); ?>pelanggan/hapus/<?php echo $db['kode_pelanggan']; ?>" onclick="return confirm('Anda yakin?');"><div class=
					"btn-delete">Hapus Data</div></a></td>
				</tr>
				<?php
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
