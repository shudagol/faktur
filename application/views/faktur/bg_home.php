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
		  <!--DWLayoutTable-->
			<tr style="background-color:#000000; color:#FFFFFF;" align="center"><td colspan="9" height="25">MANAJEMEN FAKTUR</td></tr>
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td width="80">Kode Faktur</td>
				<td width="90">Kode Pesanan</td>
				<td width="200">Nama Pelanggan</td>
				<td width="142">Tanggal Faktur</td>
				<td width="50">Jumlah Barang</td>
				<td width="50">Barang Terkirim</td>
				<td width="116">Total Bayar</td>
				<td colspan="2"><a href="<?php echo base_url(); ?>faktur/tambah"><div class="btn-add">Tambah Faktur</div></a></td>
			</tr>
			<?php
				if($dt_pesanan->num_rows()>0)
				{
					foreach($dt_pesanan->result_array() as $db)
					{
				?>
				<tr>
					<td rowspan="2"><?php echo $db['kode_faktur']; ?></td>
					<td rowspan="2"><?php echo $db['kode_pesanan']; ?></td>
					<td rowspan="2"><?php echo $db['nama_pelanggan']; ?></td>
					<td rowspan="2"><?php echo $db['tanggal_faktur']; ?></td>
					<td rowspan="2"><?php echo $db['total_barang']; ?></td>
					<td rowspan="2"><?php echo $db['qty_barang_terjual']; ?></td>
					<td rowspan="2">Rp. <?php echo number_format($db['total_bayar'],2,',','.'); ?></td>
					<td width="110"><a href="<?php echo base_url(); ?>faktur/hapus/<?php echo $db['kode_faktur'].'/'.$db['kode_pesanan']; ?>" 
					onclick="return confirm('Anda yakin?');"><div class="btn-delete">Hapus Data</div></a></td>
					<td width="80" rowspan="2"><a href="<?php echo base_url(); ?>faktur/tambah_surat_jalan/<?php echo $db['kode_faktur'].'/'.$db['kode_pesanan']; ?>" target="_blank"><div 
					class="btn-print">Cetak Surat Jalan</div></a></td>
				<tr>
					<td><a href="<?php echo base_url(); ?>faktur/cetak_faktur/<?php echo $db['kode_faktur']; ?>" target="_blank"><div class="btn-print">Cetak Faktur
					</div></a></td>
				</tr>
				<?php
					}
				}
				else
				{
					?>
					
				<tr style="text-align:center;">
					<td height="27" colspan="8" valign="top">Belum ada data</td>
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
