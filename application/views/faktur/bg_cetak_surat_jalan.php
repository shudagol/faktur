<!DOCTYPE html>
<link href="<?php echo base_url(); ?>/asset/css/style.css" rel="stylesheet">
<div id="container">
	<h1><?php echo $nama_perusahaan; ?> - SURAT JALAN</h1>
	<h2><?php echo $alamat_perusahaan; ?></h2>

	<div id="body">
		<div id="body">
			<table width="100%" cellpadding="3" cellspacing="0">
				<tr><td width="110">Kode Surat Jalan</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_surat_jalan; ?>" class=
				"input-read-only" readonly="true" style="width:280px;" name="kode_surat_jalan" /></td>
				<td width="110">Kode Faktur</td><td width="20">:</td><td><input type="text" value="<?php echo $kode_faktur; ?>" class=
				"input-read-only" readonly="true" style="width:280px;" name="kode_surat_jalan" /></td>
				
				<tr><td width="110">Kode Pesanan</td><td>:</td><td>
				<input type="text" value="<?php echo $kode_pesanan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="kode_pesanan" /></td>
				<td width="110">Tanggal Surat Jalan</td><td width="20">:</td><td><input type="text" value="<?php echo $tanggal_surat_jalan; ?>" 
				class="input-read-only" readonly="true" style="width:280px;" name="tanggal_surat_jalan" /></td></tr>
				<tr><td width="110">Nama Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $nama_pelanggan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="nama_pelanggan" /></td>
				 <td width="110">Alamat Pelanggan</td><td>:</td><td>
				<input type="text" value="<?php echo $alamat_pelanggan; ?>" class="input-read-only" readonly="true" 
				 style="width:280px;" name="nama_pelanggan" /></td></tr>
			</table>
			<div class="cleaner_h5"></div>
			<table border="1" cellpadding="4" cellspacing="0" width="100%" style=" border-collapse: collapse;" class="record">
			<tr style="background-color:#333; color:#FFFFFF;" align="center">
				<td>No.</td>
				<td>Kode Barang</td>
				<td>Nama Barang</td>
				<td>Status Barang</td>
				<td>Jumlah Barang</td>
			</tr>
			<?php $i = 1; $no=1; $jum=0;?>
			<?php foreach($this->cart->contents() as $items): ?>
			
			<?php echo form_hidden('rowid[]', $items['rowid']); ?>
			<tr class="content">
				
				<td class="td-keranjang"><?php echo $no; ?></td>
				<td class="td-keranjang"><?php echo $items['id']; ?></td>
				<td class="td-keranjang"><?php echo $items['name']; ?></td>
				<td class="td-keranjang">
				<?php if ($this->cart->has_options($items['rowid']) == TRUE): ?>
						<?php foreach ($this->cart->product_options($items['rowid']) as $option_name => $option_value): ?>
							<?php echo $option_value; ?>
						<?php endforeach; ?>
					<?php endif; ?>
				</td>
				<td class="td-keranjang"><?php echo $items['qty']; ?></td>
			</tr>
	  	
	  	<?php $i++; $no++; $jum=$jum+$items['qty']; ?>
		<?php endforeach; ?>
			<tr>
				<td colspan="4">Total Barang</td>
				<td><?php echo $jum; ?></td>
			</tr>
			</table>
			<div class="cleaner_h10"></div>
		</div>
	</div>