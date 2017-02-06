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
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="7" height="25">MASTER SUPLIER</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>Kode suplier</td>
				<td>Nama suplier</td>
				<td>Kontak</td>
				<td>Alamat</td>
				
				<td colspan="2"><a href="<?php echo base_url(); ?>suplier/tambah" class="cbpelanggan"><div class="btn-add">Tambah Data</div></a></td>
			</tr>
			<?php
				if($dt_suplier->num_rows()>0)
				{
					foreach($dt_suplier->result_array() as $db)
					{
				?>
				<tr>
					<td><?php echo $db['kode_suplier']; ?></td>
					<td><?php echo $db['nama_suplier']; ?></td>
					<td><?php echo $db['kontak']; ?></td>
					<td><?php echo $db['alamat']; ?></td>
					
					<td width="90"><a href="<?php echo base_url(); ?>suplier/edit/<?php echo $db['kode_suplier']; ?>" class="cbpelanggan"><div class="btn-edit">Edit Data</div></a></td>
					<td width="100"><a href="<?php echo base_url(); ?>suplier/hapus/<?php echo $db['kode_suplier']; ?>" onclick="return confirm('Anda yakin?');"><div class=
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
