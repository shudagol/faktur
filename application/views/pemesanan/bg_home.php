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
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="9" height="25">MANAJEMEN PEMESANAN</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>Kode Pesanan</td>
				<td>Nama Pelanggan</td>
				<td>Tanggal Pesanan</td>
				<td>Jumlah Item</td>
				<td>Jenis</td>
				<td>Status</td>
				<?php
					if($st=="Ok")
					{
				?>
				<?php
					}
					else if($st=="Pending")
					{
				?>
					<td colspan="3"><a href="<?php echo base_url(); ?>pemesanan/tambah"><div class="btn-add">Tambah Data</div></a></td>
				<?php
					}
				?>
			</tr>
			<?php
				if($dt_pesanan->num_rows()>0)
				{
					foreach($dt_pesanan->result_array() as $db)
					{
				?>
				<tr>
					<td><?php echo $db['kode_pesanan']; ?></td>
					<td><?php echo $db['nama_pelanggan']; ?></td>
					<td><?php echo $db['tanggal_pesanan']; ?></td> 
					<td align="center"><?php echo $db['jumlah']; ?></td>
					<td><?php echo $db['jenis']; ?></td>
					<td><?php echo $db['stts']; ?></td>
					
					<?php
						if($st=="Ok")
						{
					?>
					<?php
						}
						else if($db['stts']=="Pending")
						{
					?>
					<td width="100">
					<a href="<?php echo base_url(); ?>faktur/buat_faktur/<?php echo $db['kode_pesanan']; ?>">
					<div class="btn-print">Buat Faktur</div></a>
					</td>
					<td width="90"><a href="<?php echo base_url(); ?>pemesanan/edit/<?php echo $db['kode_pesanan']; ?>"><div class="btn-edit">Edit Data</div></a></td>
					<td width="100"><a href="<?php echo base_url(); ?>pemesanan/hapus/<?php echo $db['kode_pesanan']; ?>" onclick="return confirm('Anda yakin?');"><div class=
					"btn-delete">Hapus Data</div></a></td>
					<?php
						}
					?>
				</tr>
				<?php
					}
				}
				else
				{
					?>
					
				<tr style="text-align:center;">
					<td colspan="9">Belum ada data</td>
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
